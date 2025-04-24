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
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-expired-pending-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // --- Định nghĩa thời gian hết hạn thanh toán (24 giờ) ---
        $paymentTimeLimitMinutes = 1;
        $this->info("Kiểm tra các đơn hàng chờ thanh toán online quá {$paymentTimeLimitMinutes} phút (TESTING)...");

        // Thời gian ngưỡng: Hiện tại trừ đi số giờ giới hạn
        $threshold = Carbon::now()->subMinutes($paymentTimeLimitMinutes);

        // Tìm các đơn hàng thỏa mãn điều kiện:
        // - status = 'pending' (Đang chờ xử lý/thanh toán)
        // - payment_method = 'wallet' (Hoặc các phương thức online khác cần xử lý)
        // - Thời gian cập nhật cuối (updated_at) trước thời gian ngưỡng
        //   (Dùng updated_at vì nó có thể được cập nhật khi áp coupon hoặc chỉnh sửa đơn hàng)
        $expiredOrders = Order::where('status', 'pending')
            ->where('updated_at', '<', $threshold)
            ->with('items.productVariant', 'user') // Load sẵn items, variant để hoàn kho và user để tìm cart
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('Không tìm thấy đơn hàng chờ thanh toán online nào bị quá hạn.');
            return;
        }

        $count = $expiredOrders->count();
        $this->info("Tìm thấy {$count} đơn hàng chờ thanh toán online quá hạn cần xử lý.");

        // Lặp qua từng đơn hàng quá hạn
        foreach ($expiredOrders as $order) {
            // Bắt đầu transaction cho mỗi đơn hàng để đảm bảo toàn vẹn
            DB::beginTransaction();
            try {
                $userId = $order->user_id; // Lấy user ID để tìm giỏ hàng
                $originalStatus = $order->status;

                // 1. Cập nhật trạng thái đơn hàng thành 'cancelled'
                $order->status = 'cancelled';
                $order->note = ($order->note ? $order->note . "\n" : '') . "Đơn hàng tự động hủy do quá hạn thanh toán online sau {$paymentTimeLimitMinutes} giờ.";
                $order->cancelled_at = now(); // Lưu thời gian hủy (nếu có cột)
                // Xóa luôn ID cart item tạm nếu bạn vẫn còn lưu trên order (dù không cần nữa)
                $order->temporary_cart_ids = null;
                $order->save();

                // 2. Hoàn trả tồn kho
                $restoredStock = false; // Cờ kiểm tra xem có hoàn kho không
                if ($order->items->isNotEmpty()) {
                    foreach ($order->items as $item) {
                        if ($variant = $item->productVariant) {
                            $variant->increment('quantity', $item->quantity);
                            $restoredStock = true;
                        } else {
                            Log::warning("Không tìm thấy Variant ID {$item->product_variant_id} để hoàn kho khi hủy Order ID {$order->id} do quá hạn.");
                        }
                    }
                    if ($restoredStock) {
                        Log::info("Đã hoàn kho cho các sản phẩm của đơn hàng hủy {$order->id} do quá hạn.");
                    }
                }

                // 3. Xóa các CartDetail có status = 'checkout' của user này
                // (Đây là các item đã bị ẩn khỏi giỏ hàng khi bắt đầu checkout đơn hàng này)
                $cart = Cart::where('user_id', $userId)->first();
                if ($cart) {
                    $deletedCount = CartDetail::where('cart_id', $cart->id)
                        ->where('status', 'checkout') // Chỉ xóa những item đang checkout
                        ->delete();
                    if ($deletedCount > 0) {
                        Log::info("Đã xóa {$deletedCount} CartDetail ('checkout' status) của User ID {$userId} do hủy Order ID {$order->id} quá hạn.");
                    }
                }

                DB::commit(); // Lưu tất cả thay đổi thành công
                $this->info("Đã hủy đơn hàng quá hạn ID {$order->id} (Trạng thái cũ: {$originalStatus}).");

            } catch (\Exception $e) {
                DB::rollBack(); // Hoàn tác nếu có lỗi
                Log::error("Lỗi khi hủy đơn hàng quá hạn ID {$order->id}: " . $e->getMessage());
                $this->error("Lỗi khi xử lý đơn hàng ID {$order->id}. Kiểm tra log.");
            }
        } // Kết thúc foreach

        $this->info("Hoàn tất kiểm tra và xử lý hủy đơn hàng quá hạn.");
    }
}
