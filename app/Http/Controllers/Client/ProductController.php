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
        $query = $request->input('search'); 
        $products = Product::where('name', 'LIKE', "%{$query}%")->get(); 

        return view('client.products.search', compact('products', 'query')); 
    }


    public function index()
    {
        $products = Product::all(); 

        return view('client.home.home', compact('products'));
    }

}
