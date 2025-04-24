<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function viewHome()
    {
        $newProducts = Product::where('publish', 1)
            ->where('is_new', 1) // Dựa vào cờ is_new
            ->latest() // Tương đương orderBy('created_at', 'desc')
            ->limit(10) // Giới hạn số lượng cho carousel
            ->get();

        // Lấy Sản phẩm Sale (ví dụ: is_sale = 1, sắp xếp theo ngày cập nhật, giới hạn 10)
        $saleProducts = Product::where('publish', 1)
            ->where('is_sale', 1) // Dựa vào cờ is_sale
            // ->whereColumn('price', '<', 'original_price') // Hoặc nếu bạn có giá gốc để so sánh
            ->latest('updated_at') // Ưu tiên sản phẩm sale mới cập nhật
            ->limit(10)
            ->get();


        $hotProductsQuery = Product::where('publish', 1)
            ->where('is_trending', 1);
        $hotProductsQuery->orderBy('updated_at', 'desc');
        $hotProducts = $hotProductsQuery->limit(10)->get();
        $comment = Review::limit(5)->get();

        return view('client.home.home')->with([
            'newProducts' => $newProducts,
            'saleProducts' => $saleProducts,
            'hotProducts' => $hotProducts,
            'comment' => $comment
        ]);
    }

}
