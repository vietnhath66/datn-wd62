<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Banner;
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

        $banners = Banner::where('is_active', true)->where('position', 'home_top')->orderBy('position')->get();

        $bannerslide = Banner::where('is_active', true)->where('position', 'slide')->orderBy('position')->get();

        // dd($comment);
        return view('client.home.home')->with([
            'newProducts' => $newProducts,
            'saleProducts' => $saleProducts,
            'hotProducts' => $hotProducts,
            'comment' => $comment,
            'banners' => $banners,
            'bannerslide' => $bannerslide
        ]);
    }
}
