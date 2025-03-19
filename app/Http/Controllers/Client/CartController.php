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
        $cart = Cart::where('user_id', $userId)->with('items.productVariant.product')->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId
            ]);
        }

        // Lấy product variant theo fixProductId
        $productVariant = ProductVariant::where('product_id', $fixProductId)->first();
        // dd($productVariant);

        if ($productVariant) {
            $cartItem = CartDetail::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariant->id)
                ->first();

            if ($cart->items()->count() === 0) {
                $product = Product::inRandomOrder()->first();

                if ($product) {
                    $randomProductVariant = ProductVariant::where('product_id', $product->id)->first();
                }

                // Kiểm tra xem productVariant có bị null không
                if (!$cartItem && isset($randomProductVariant)) {
                    CartDetail::create([
                        'cart_id' => $cart->id,
                        'product_variant_id' => $randomProductVariant->id, // Chỉ dùng nếu chắc chắn không bị null
                        'quantity' => 1,
                        'price' => optional($randomProductVariant->product)->price ?? 0
                    ]);
                }
            }
        }

        return view('client.cart.cart')->with([
            'cart' => $cart
        ]);
    }



}
