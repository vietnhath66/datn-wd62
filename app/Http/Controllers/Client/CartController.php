<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function viewCart()
    {
        $userId = 2; 
        $fixProductId = 20; 
        $fixVariantId = 9; 

      
        $cart = Cart::where('user_id', $userId)->with('items.productVariant.product')->first();

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
                    'product_id' => $productVariant->product_id,
                    'product_variant_id' => $productVariant->id,
                    'quantity' => 1,
                    'price' => optional($productVariant->product)->price ?? 0
                ]);
            } else {
                // Nếu sản phẩm đã có trong giỏ, tăng số lượng lên
                $cartItem->increment('quantity');
            }
        }

        return view('client.cart.cart')->with([
            'cart' => $cart
        ]);
    }




}
