<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm
        return view('client.productss.productss', compact('products'));
    }

    //     public function show($id)
// {
//     $product = Product::findOrFail($id);

    //     // Lấy các biến thể của sản phẩm với color và size
//     $variants = ProductVariant::where('product_id', $id)
//                                 ->whereNull('deleted_at')  // Lọc các bản không bị xóa
//                                 ->get();
//                                 // dd($variants);

    //     // Lấy tất cả màu sắc có sẵn (unique)
//     $colors = $variants->pluck('name_variant_color')->unique();

    //     // Lấy tất cả kích thước có sẵn (unique)
//     $sizes = $variants->pluck('name_variant_size')->unique();

    //     // Truyền dữ liệu vào view
//     return view('client.productss.detailProducts', compact('product', 'variants', 'colors', 'sizes'));
// }
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Lấy các biến thể của sản phẩm với color và size
        $variants = ProductVariant::where('product_id', $id)
            ->whereNull('deleted_at')  // Lọc các bản không bị xóa
            ->get();
        // dd($variants);
        // Lấy tất cả các màu có sẵn (unique)
        $colors = $variants->pluck('name_variant_color')->unique();

        // Truyền dữ liệu vào view
        // dd($variants);
        
        return view('client.productss.detailProducts', compact('product', 'variants', 'colors'));

    }



    public function quickView($id)
    {
        $product = Product::findOrFail($id);
        return view('client.productss.modal', compact('product'));
    }





}

