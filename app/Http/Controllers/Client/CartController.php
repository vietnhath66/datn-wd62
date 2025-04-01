<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use Auth;
use DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function viewCart()
    {
        $userId = 2;
        $fixProductId = 20;
        $fixVariantId = 9;

        $cart = Cart::where('user_id', $userId)->with('items.productVariant')->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId
            ]);
        }

        // Lấy biến thể sản phẩm cố định
        $productVariant = ProductVariant::where('product_id', $fixProductId)
            ->where('id', $fixVariantId) // Chỉ lấy đúng variant mong muốn
            ->first();

        if ($productVariant) {
            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ chưa
            $cartItem = CartDetail::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariant->id)
                ->first();

            if (!$cartItem) {
                // Nếu sản phẩm chưa có trong giỏ, thêm mới
                CartDetail::create([
                    'cart_id' => $cart->id,
                    'product_id' => $fixProductId,
                    'product_variant_id' => $fixVariantId,
                    'quantity' => 1,
                    'price' => $productVariant->price
                ]);
            } else {
                // Nếu sản phẩm đã có trong giỏ, tăng số lượng lên
                // $cartItem->increment('quantity');
                $cartItem->update([
                    'price' => $cartItem->quantity * $cartItem->productVariant->price
                ]);
            }

            $cartTotal = 0;
            foreach ($cart->items as $item) {
                $cartTotal += $item->quantity * $item->productVariant->price;
            }

            return view('client.cart.cart')->with([
                'cart' => $cart,
                'cartTotal' => $cartTotal
            ]);
        }
    }


    public function updateCart(Request $request)
    {
        $cartItem = CartDetail::find($request->product_id);

        if ($cartItem) {
            $cartItem->update(['quantity' => $request->quantity]);

            // Lấy tổng tiền giỏ hàng sau khi cập nhật
            $cartTotal = CartDetail::sum(DB::raw('quantity * price'));

            return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công');
        }

        return redirect()->back()->with('error', 'Có lỗi xảy ra!');
    }


    public function deleteCart(Request $request, $id)
    {
        try {
            $cartItem = CartDetail::find($id);

            if (!$cartItem) {
                return response()->json(['message' => 'Sản phẩm không tồn tại!'], 404);
            }

            // Lấy thông tin giỏ hàng
            $cart = Cart::find($cartItem->cart_id);

            // Xóa sản phẩm khỏi giỏ hàng (Xóa cứng)
            $cartItem->delete();

            // Tính lại tổng tiền giỏ hàng
            $totalAmount = CartDetail::where('cart_id', $cart->id)
                ->sum(DB::raw('quantity * price'));

            // Trả về JSON để cập nhật giao diện bằng Ajax
            return redirect()->back()->with([
                'success' => 'Xoá sản phẩm thành công!',
                'total_amount' => number_format($totalAmount, 0, ',', '.'),
                'sumQuantity' => CartDetail::where('cart_id', $cart->id)->sum('quantity')
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }


}