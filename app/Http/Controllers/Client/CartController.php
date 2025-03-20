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

        $cart = Cart::where('user_id', $userId)->with('items.productVariant.attributes')->first();

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
            // Kiểm tra xưuct)->price
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
