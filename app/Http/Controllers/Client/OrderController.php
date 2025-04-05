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
        $userId = auth()->id();

        // Lấy giỏ hàng của user
        $cart = Cart::where('user_id', $userId)->with('items.productVariant')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Kiểm tra xem user đã có đơn hàng 'pending' chưa
        $order = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            // Nếu chưa có đơn hàng, tạo mới
            do {
                $barcode = mt_rand(100000000, 999999999);
            } while (Order::where('barcode', $barcode)->exists());

            $order = Order::create([
                'user_id' => $userId,
                'email' => $request->email,
                'phone' => $request->phone,
                'total' => 0, // Cập nhật sau khi tính tổng tiền
                'status' => 'pending',
                'payment_status' => 'pending',
                'address' => $request->address,
                'number_house' => $request->number_house,
                'neighborhood' => $request->neighborhood,
                'district' => $request->district,
                'province' => $request->province,
                'coupon' => $request->coupon ?? null,
                'barcode' => $barcode,
            ]);
        } else {
            // Nếu có đơn hàng pending, cập nhật thông tin đơn hàng
            $order->update([
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'number_house' => $request->number_house,
                'neighborhood' => $request->neighborhood,
                'district' => $request->district,
                'province' => $request->province,
                'coupon' => $request->coupon ?? null,
            ]);
        }

        $totalPrice = 0;

        // **Xóa các sản phẩm cũ trong order_items**
        OrderDetail::where('order_id', $order->id)->delete();

        // Thêm lại sản phẩm từ giỏ hàng
        foreach ($cart->items as $item) {
            $product = Product::find($item->product_id);
            if (!$product) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong hệ thống.');
            }

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

        // Lưu order_id vào session để hiển thị trên trang thanh toán
        Session::put('order_id', $order->id);

        return redirect()->route('client.order.viewOrder');
    }



    public function completeOrder(Request $request)
    {
        // Kiểm tra order_id có trong session không
        $orderId = Session::get('order_id');
        if (!$orderId) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Lấy đơn hàng từ database
        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Đơn hàng không tồn tại.');
        }

        // Cập nhật thông tin đơn hàng với dữ liệu mới từ form
        $order->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'number_house' => $request->number_house,
            'neighborhood' => $request->neighborhood,
            'district' => $request->district,
            'province' => $request->province,
            'payment_status' => $request->payment_status == 'wallet' ? 'wallet' : 'cod', // Cập nhật trạng thái thanh toán
            'status' => 'pending', // Đơn hàng được xác nhận
        ]);

        // Xoá giỏ hàng sau khi đặt hàng
        CartDetail::where('cart_id', $order->user_id)->delete();

        // Xóa session order_id sau khi hoàn tất thanh toán
        Session::forget('order_id');

        return redirect()->route('client.viewHome')->with('success', 'Đơn hàng đã được xác nhận.');
    }

}
