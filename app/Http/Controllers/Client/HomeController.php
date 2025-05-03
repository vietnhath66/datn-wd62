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
            ->where('is_new', 1)
            ->latest()
            ->limit(10)
            ->get();

        $saleProducts = Product::where('publish', 1)
            ->where('is_sale', 1)
            ->latest('updated_at')
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
