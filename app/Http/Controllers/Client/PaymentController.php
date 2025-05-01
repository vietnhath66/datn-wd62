<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use DB;
use Illuminate\Http\Request;
use Log;
use Mail;

class PaymentController extends Controller
{
    public function momoReturn(Request $request)
    {
        Log::info('MoMo Return Request:', $request->all());

        $orderIdFromMomo = $request->query('orderId');
        $orderIdParts = explode('_', $orderIdFromMomo);
        $originalOrderId = $orderIdParts[0] ?? null;

        if ($originalOrderId) {

            return redirect()->route('client.account.accountOrderDetail', $originalOrderId)
                ->with([
                    'momo_return_data' => $request->query(),
                    'success',
                    'Đơn hàng đã được đặt thành công! Vui lòng chờ admin xác nhận.'
                ]);
        } else {

            return redirect()->route('client.account.accountMyOrder')->with([
                'momo_return_data',
                $request->query(),
                'success',
                'Đơn hàng đã được đặt thành công! Vui lòng chờ admin xác nhận.'
            ]);
        }
    }


    public function momoNotify(Request $request)
    {
        Log::info('MoMo IPN Received:', $request->all());

        $momoConfig = config('services.momo');
        $secretKey = $momoConfig['sandbox_secret_key'] ?? null;
        if (empty($secretKey) || empty($momoConfig['sandbox_partner_code']) || empty($momoConfig['sandbox_access_key'])) {
            Log::error('MoMo IPN Failed: Missing configuration.');
            return response()->json(['resultCode' => 99, 'message' => 'Configuration error'], 400);
        }
        $partnerCode = $momoConfig['sandbox_partner_code'];
        $accessKey = $momoConfig['sandbox_access_key']; 

        $momoSignature = $request->input('signature');
        $requestId = $request->input('requestId');
        $amount = $request->input('amount');
        $momoOrderId = $request->input('orderId');
        $orderInfo = $request->input('orderInfo');
        $orderType = $request->input('orderType');
        $transId = $request->input('transId');
        $resultCode = $request->input('resultCode');
        $message = $request->input('message');
        $payType = $request->input('payType');
        $responseTime = $request->input('responseTime');
        $extraData = $request->input('extraData');

        if (empty($momoSignature)) {
            Log::error('MoMo IPN Failed: Missing signature.');
            return response()->json(['resultCode' => 98, 'message' => 'Missing signature'], 400);
        }

        $rawHash = "accessKey=" . $accessKey . 
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&message=" . $message .
            "&orderId=" . $momoOrderId .
            "&orderInfo=" . $orderInfo .
            "&orderType=" . $orderType .
            "&partnerCode=" . $partnerCode . 
            "&payType=" . $payType .
            "&requestId=" . $requestId .
            "&responseTime=" . $responseTime .
            "&resultCode=" . $resultCode .
            "&transId=" . $transId;

        $expectedSignature = hash_hmac('sha256', $rawHash, $secretKey);

        if ($momoSignature !== $expectedSignature) {
            Log::error('MoMo IPN Failed: Invalid signature.');
            return response()->json(['resultCode' => 97, 'message' => 'Invalid signature'], 400);
        }


        $orderIdParts = explode('_', $momoOrderId);
        $originalOrderId = $orderIdParts[0] ?? null;
        if (!$originalOrderId || !is_numeric($originalOrderId)) {
            Log::error("MoMo IPN Failed: Invalid original Order ID from '{$momoOrderId}'.");
            return response()->json($this->momoIpnResponse($request, 99, 'Invalid Order ID Format')); 
        }

        $order = Order::find($originalOrderId);
        if (!$order) {
            Log::error("MoMo IPN Failed: Order ID '{$originalOrderId}' not found.");
            return response()->json($this->momoIpnResponse($request, 0, "Order not found but acknowledged"));
        }

        if ($resultCode == 0) { 
            Log::info("MoMo IPN Success received for Order ID {$order->id}.");

            if ($order->status !== 'pending' || $order->payment_method !== 'wallet') {
                Log::warning("MoMo IPN Warning: Order {$order->id} already processed or not awaiting wallet payment. Ignoring IPN.");
                return response()->json($this->momoIpnResponse($request, 0, "Success (Already processed)"));
            }

            if ((string) round($order->total) !== (string) $amount) { 
                Log::critical("MoMo IPN CRITICAL: Amount mismatch for Order {$order->id}. Expected: {$order->total}, Received: {$amount}. IPN:", $request->all());
                $order->status = 'payment_error';
                $order->note = "Lỗi IPN MoMo: Sai số tiền (Expected: {$order->total}, Received: {$amount})";
                $order->save();
                return response()->json($this->momoIpnResponse($request, 0, "Success (Amount mismatch recorded)"));
            }

            DB::beginTransaction();
            try {
                $order->status = 'processing'; 
                $order->payment_method = 'wallet';   
                $order->payment_status = 'paid';   
                $order->paid_at = now();         
                $order->payment_transaction_id = $transId; 

                $order->save();

                $cart = Cart::where('user_id', $order->user_id)->first();
                if ($cart) {
                    $deletedCount = CartDetail::where('cart_id', $cart->id)
                        ->where('status', 'checkout')
                        ->delete();
                    Log::info("MoMo IPN Success Order {$order->id}: Deleted {$deletedCount} 'checkout' status CartDetail items for Cart ID {$cart->id}.");
                }

                DB::commit();

                Log::info("MoMo IPN Success: Order {$order->id} finalized. Status: 'processing', Payment: 'paid'. Cart items cleared.");

                try {
                    $order->loadMissing(['items.product', 'items.productVariant']);
                    Mail::to($order->email)->send(new OrderPlacedMail($order));
                    Log::info("Sent OrderPlacedMail for paid MoMo Order ID {$order->id} to {$order->email}");
                } catch (\Exception $e) {
                    Log::error("Failed to send OrderPlacedMail after IPN for Order ID {$order->id}: " . $e->getMessage());
                }

                return response()->json($this->momoIpnResponse($request, 0, "Confirm Success"));

            } catch (\Exception $e) {
                DB::rollBack();
                Log::critical("MoMo IPN CRITICAL: Exception during DB update for Order {$order->id} after success: " . $e->getMessage());
                return response()->json($this->momoIpnResponse($request, 99, "Internal Server Error"), 500);
            }

        } else { 
            Log::warning("MoMo IPN Received non-success status for Order {$order->id}. ResultCode: {$resultCode}.");
            if ($order->status === 'pending' && $order->payment_method === 'wallet') {
                $order->status = 'payment_failed'; 
                $order->payment_status = 'failed';
                $order->note = $order->note . "\nMoMo Payment Failed (IPN): " . $message;
                $order->save();
            }
            return response()->json($this->momoIpnResponse($request, 0, "Acknowledged (Payment Failed/Other)"));
        }
    }


    private function momoIpnResponse(Request $request, int $resultCode, string $message)
    {
        return [
            "partnerCode" => $request->input('partnerCode'), 
            "requestId" => $request->input('requestId'),
            "orderId" => $request->input('orderId'),
            "resultCode" => $resultCode,
            "message" => $message,
            "responseTime" => now()->timestamp * 1000
        ];
    }
}
