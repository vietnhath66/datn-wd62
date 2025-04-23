<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function viewSearch(Request $request)
    {
        $query = $request->input('search'); // Lấy từ khóa từ form
        $products = Product::where('name', 'LIKE', "%{$query}%")->get(); // Tìm sản phẩm theo tên

        return view('client.products.search', compact('products', 'query')); // Trả về view kết quả
    }


    public function index()
{
    $products = Product::all(); // Lấy tất cả sản phẩm từ bảng products

    // Nếu bạn có thêm bảng size, color... có thể load thêm bằng with() nếu cần
    return view('client.home.home', compact('products'));
}

}
