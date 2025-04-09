<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;


class HomeController extends Controller
{

    public function viewHome()
{
    $products = Product::with('variants')->get(); // hoặc bạn có thể thay đổi query theo ý bạn

    $colors = Attribute::where('attribute_catalogue_id', 10)->get();
    $sizes = Attribute::where('attribute_catalogue_id', 11)->get();

    return view('client.home.home', compact('products', 'colors', 'sizes'));
}

}
