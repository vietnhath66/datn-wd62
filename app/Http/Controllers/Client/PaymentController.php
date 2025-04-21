<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use DB;
use Illuminate\Http\Request;
use Log;

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
        // 1. Log toàn bộ request đến từ MoMo
        Log::info('MoMo IPN Received:', $request->all());

        // 2. Lấy cấu hình MoMo (ưu tiên kiểm tra production trước nếu có)
        $momoConfig = config('services.momo');
        // Ví dụ: dùng key sandbox, bạn cần logic để chọn đúng key production/sandbox
        $secretKey = $momoConfig['sandbox_secret_key'] ?? null;
        if (empty($secretKey) || empty($momoConfig['sandbox_partner_code']) || empty($momoConfig['sandbox_access_key'])) {
            Log::error('MoMo IPN Failed: Missing configuration.');
            // Phản hồi lỗi theo cách MoMo hiểu (Xem Docs!)
            return response()->json(['resultCode' => 99, 'message' => 'Configuration error'], 400);
        }
        $partnerCode = $momoConfig['sandbox_partner_code'];
        $accessKey = $momoConfig['sandbox_access_key']; // Cần accessKey để tạo signature kiểm tra

        // 3. Xác thực Chữ ký (QUAN TRỌNG!)
        // Lấy các tham số MoMo gửi sang (TÊN THAM SỐ PHẢI ĐÚNG THEO DOCS IPN)
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
        // Thêm partnerCode và accessKey vào rawHash nếu MoMo yêu cầu
        // $partnerCodeRequest = $request->input('partnerCode');
        // $accessKeyRequest = $request->input('accessKey');

        if (empty($momoSignature)) {
            Log::error('MoMo IPN Failed: Missing signature.');
            return response()->json(['resultCode' => 98, 'message' => 'Missing signature'], 400);
        }

        // --- Tái tạo chuỗi rawHash để kiểm tra chữ ký ---
        // !!! THỨ TỰ VÀ THAM SỐ PHẢI CHÍNH XÁC THEO TÀI LIỆU IPN CỦA MOMO !!!
        // Ví dụ:
        $rawHash = "accessKey=" . $accessKey . // Dùng accessKey từ config của bạn
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&message=" . $message .
            "&orderId=" . $momoOrderId .
            "&orderInfo=" . $orderInfo .
            "&orderType=" . $orderType .
            "&partnerCode=" . $partnerCode . // Dùng partnerCode từ config của bạn
            "&payType=" . $payType .
            "&requestId=" . $requestId .
            "&responseTime=" . $responseTime .
            "&resultCode=" . $resultCode .
            "&transId=" . $transId;

        $expectedSignature = hash_hmac('sha256', $rawHash, $secretKey);

        // So sánh chữ ký
        if ($momoSignature !== $expectedSignature) {
            Log::error('MoMo IPN Failed: Invalid signature.');
            // Phản hồi lỗi cho MoMo
            return response()->json(['resultCode' => 97, 'message' => 'Invalid signature'], 400);
        }

        // --- Chữ ký hợp lệ, xử lý tiếp ---

        // 4. Tách lấy ID đơn hàng gốc
        $orderIdParts = explode('_', $momoOrderId);
        $originalOrderId = $orderIdParts[0] ?? null;
        if (!$originalOrderId || !is_numeric($originalOrderId)) {
            Log::error("MoMo IPN Failed: Invalid original Order ID from '{$momoOrderId}'.");
            return response()->json($this->momoIpnResponse($request, 99, 'Invalid Order ID Format')); // Phản hồi lỗi cho MoMo
        }

        // 5. Tìm Đơn hàng và Khóa để tránh xử lý đồng thời (nếu cần)
        // $order = Order::lockForUpdate()->find($originalOrderId); // Khóa đơn hàng nếu cần cẩn thận hơn
        $order = Order::find($originalOrderId);
        if (!$order) {
            Log::error("MoMo IPN Failed: Order ID '{$originalOrderId}' not found.");
            // Vẫn báo thành công cho MoMo để không gửi lại
            return response()->json($this->momoIpnResponse($request, 0, "Order not found but acknowledged"));
        }

        // --- 6. Xử lý dựa trên Kết quả Thanh toán (resultCode) ---
        if ($resultCode == 0) { // Thanh toán THÀNH CÔNG
            Log::info("MoMo IPN Success received for Order ID {$order->id}.");

            // 6.1. Kiểm tra xem đơn hàng đã được xử lý thành công trước đó chưa
            if ($order->status !== 'pending' || $order->payment_method !== 'wallet') {
                Log::warning("MoMo IPN Warning: Order {$order->id} already processed or not awaiting wallet payment. Ignoring IPN.");
                return response()->json($this->momoIpnResponse($request, 0, "Success (Already processed)"));
            }

            // 6.2. Kiểm tra số tiền
            if ((string) round($order->total) !== (string) $amount) { // So sánh dạng chuỗi sau khi làm tròn
                Log::critical("MoMo IPN CRITICAL: Amount mismatch for Order {$order->id}. Expected: {$order->total}, Received: {$amount}. IPN:", $request->all());
                $order->status = 'payment_error';
                $order->note = "Lỗi IPN MoMo: Sai số tiền (Expected: {$order->total}, Received: {$amount})";
                $order->save();
                return response()->json($this->momoIpnResponse($request, 0, "Success (Amount mismatch recorded)"));
            }

            // 6.3. === CẬP NHẬT ĐƠN HÀNG, XÓA GIỎ HÀNG ===
            DB::beginTransaction();
            try {
                $order->status = 'processing'; // <-- Đặt trạng thái Đang xử lý
                $order->payment_method = 'wallet';   // <-- Đặt trạng thái Đã thanh toán
                $order->payment_status = 'paid';   // <-- Đặt trạng thái Đã thanh toán
                $order->paid_at = now();         // <-- Lưu thời gian thanh toán (cần cột này)
                $order->payment_transaction_id = $transId; // <-- Lưu mã GD MoMo (cần cột này)

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

                // (Gửi email/thông báo ở đây)

                // 7. Phản hồi thành công cho MoMo
                return response()->json($this->momoIpnResponse($request, 0, "Confirm Success"));

            } catch (\Exception $e) {
                DB::rollBack();
                Log::critical("MoMo IPN CRITICAL: Exception during DB update for Order {$order->id} after success: " . $e->getMessage());
                // Trả về lỗi cho MoMo (Xem docs MoMo)
                return response()->json($this->momoIpnResponse($request, 99, "Internal Server Error"), 500);
            }

        } else { // Thanh toán THẤT BẠI theo IPN
            Log::warning("MoMo IPN Received non-success status for Order {$order->id}. ResultCode: {$resultCode}.");
            if ($order->status === 'pending' && $order->payment_method === 'wallet') {
                $order->status = 'payment_failed'; // Cập nhật trạng thái thất bại
                $order->payment_status = 'failed';
                $order->note = $order->note . "\nMoMo Payment Failed (IPN): " . $message;
                $order->save();
            }
            // Vẫn phản hồi thành công cho MoMo để họ không gửi lại
            return response()->json($this->momoIpnResponse($request, 0, "Acknowledged (Payment Failed/Other)"));
        }
    }


    private function momoIpnResponse(Request $request, int $resultCode, string $message)
    {
        // Cấu trúc response này CẦN PHẢI ĐÚNG THEO TÀI LIỆU IPN CỦA MOMO
        return [
            "partnerCode" => $request->input('partnerCode'), // Nên lấy từ request gốc MoMo gửi sang
            "requestId" => $request->input('requestId'),
            "orderId" => $request->input('orderId'),
            "resultCode" => $resultCode,
            "message" => $message,
            "responseTime" => now()->timestamp * 1000
        ];
    }
}
