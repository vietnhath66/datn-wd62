<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm
        return view('client.productss.productss', compact('products'));
    }
   
}

