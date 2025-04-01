<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Session;

class OrderController extends Controller
{
    public function viewOrder()
    {
        $orderId = Session::get('order_id');
        if (!$orderId) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        $order = Order::with('items.product')->find($orderId);
        $totalPrice = $order ? $order->total : 0;
        $user = User::find(2);

        if (!$order) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        return view('client.order.order')->with([
            'order' => $order,
            'totalPrice' => $totalPrice,
            'user' => $user
        ]);
    }


    public function checkout(Request $request)
    {
        $userId = 2; // Lấy user_id của user hiện tại

        // Lấy giỏ hàng của user
        $cart = Cart::where('user_id', $userId)->with('items.productVariant')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Tạo đơn hàng mới
        $order = Order::create([
            'user_id' => $userId,
            'total' => 0, // Cập nhật sau khi tính tổng tiền
            'status' => 'pending',
        ]);

        $totalPrice = 0;

        foreach ($cart->items as $item) {
            // Kiểm tra sản phẩm có tồn tại không
            $product = Product::find($item->product_id);
            if (!$product) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong hệ thống.');
            }

            // Thêm sản phẩm vào bảng order_items
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'quantity' => $item->quantity,
                'price' => $item->productVariant->price, // Lấy giá từ biến thể sản phẩm
            ]);

            $totalPrice += $item->quantity * $item->productVariant->price;
        }

        // Cập nhật tổng tiền cho đơn hàng
        $order->update(['total' => $totalPrice]);

        // Xoá giỏ hàng sau khi đặt hàng
        CartDetail::where('cart_id', $cart->id)->delete();

        // Lưu order_id vào session để hiển thị trên trang thanh toán
        Session::put('order_id', $order->id);

        return redirect()->route('client.order.viewOrder')->with('success', 'Chuyển sang trang thanh toán');
    }


}
