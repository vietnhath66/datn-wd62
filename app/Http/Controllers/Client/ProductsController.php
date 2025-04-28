<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\ProductCatalogue;
use App\Http\Controllers\Controller;


class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm

        
       

        return view('client.productss.productss', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Lấy các biến thể của sản phẩm với color và size
        $variants = ProductVariant::where('product_id', $id)
            ->whereNull('deleted_at')  // Lọc các bản không bị xóa
            ->get();
        // dd($variants);
        $ab = Product::where('product_catalogue_id', $product->product_catalogue_id)
        ->where('id', '!=', $product->id)
        ->latest()
        ->take(5)
        ->get();
        // Lấy tất cả các màu có sẵn (unique)
        $colors = $variants->pluck('name_variant_color')->unique();

        // Truyền dữ liệu vào view
        // dd($variants);
        return view('client.productss.detailProducts', compact('product', 'variants', 'colors','ab'));

    }


    
}

