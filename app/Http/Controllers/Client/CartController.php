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
        $cart = Cart::where('user_id', $userId)->with('items.productVariant.product')->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId
            ]);
        }

        if ($cart->items()->count() === 0) {
            $product = Product::inRandomOrder()->first();

            if ($product) {
                if ($product && isset($product->id)) {
                    $productVariant = ProductVariant::where('product_id', $product->id)->first();
                }

                if ($productVariant) {
                    CartDetail::create([
                        'cart_id' => $cart->id,
                        'product_variant_id' => $productVariant->id,
                        'quantity' => 1,
                        'price' => $product->price
                    ]);
                }
            }
        }

        return view('client.cart.cart')->with([
            'cart' => $cart
        ]);
    }


}
