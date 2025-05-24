<?php

namespace App\Console\Commands;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Log;

class CancelExpiredPendingOrders extends Command
{
    protected $signature = 'app:cancel-expired-pending-orders';

    protected $description = 'Command description';

    public function handle(): void
    {
        $paymentTimeLimitMinutes = 1;
        $this->info("Kiểm tra các đơn hàng chờ thanh toán online quá {$paymentTimeLimitMinutes} phút (TESTING)...");

        $threshold = Carbon::now()->subMinutes($paymentTimeLimitMinutes);

        $expiredOrders = Order::where('status', 'pending')
            ->where('updated_at', '<', $threshold)
            ->with('items.productVariant', 'user')
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('Không tìm thấy đơn hàng chờ thanh toán online nào bị quá hạn.');
            return;
        }

        $count = $expiredOrders->count();
        $this->info("Tìm thấy {$count} đơn hàng chờ thanh toán online quá hạn cần xử lý.");

        foreach ($expiredOrders as $order) {
            DB::beginTransaction();
            try {
                $userId = $order->user_id;
                $originalStatus = $order->status;

                $order->status = 'cancelled';
                $order->note = ($order->note ? $order->note . "\n" : '') . "Đơn hàng tự động hủy do quá hạn thanh toán sau {$paymentTimeLimitMinutes} giờ.";
                $order->cancelled_at = now();
                $order->temporary_cart_ids = null;
                $order->save();

                // $restoredStock = false;
                // if ($order->items->isNotEmpty()) {
                //     foreach ($order->items as $item) {
                //         if ($variant = $item->productVariant) {
                //             $variant->increment('quantity', $item->quantity);
                //             $restoredStock = true;
                //         } else {
                //             Log::warning("Không tìm thấy Variant ID {$item->product_variant_id} để hoàn kho khi hủy Order ID {$order->id} do quá hạn.");
                //         }
                //     }
                //     if ($restoredStock) {
                //         Log::info("Đã hoàn kho cho các sản phẩm của đơn hàng hủy {$order->id} do quá hạn.");
                //     }
                // }

                $cart = Cart::where('user_id', $userId)->first();
                if ($cart) {
                    $deletedCount = CartDetail::where('cart_id', $cart->id)
                        ->where('status', 'checkout')
                        ->delete();
                    if ($deletedCount > 0) {
                        Log::info("Đã xóa {$deletedCount} CartDetail ('checkout' status) của User ID {$userId} do hủy Order ID {$order->id} quá hạn.");
                    }
                }

                DB::commit();
                $this->info("Đã hủy đơn hàng quá hạn ID {$order->id} (Trạng thái cũ: {$originalStatus}).");

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Lỗi khi hủy đơn hàng quá hạn ID {$order->id}: " . $e->getMessage());
                $this->error("Lỗi khi xử lý đơn hàng ID {$order->id}. Kiểm tra log.");
            }
        }

        $this->info("Hoàn tất kiểm tra và xử lý hủy đơn hàng quá hạn.");
    }
}
