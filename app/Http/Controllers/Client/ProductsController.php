<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use App\Models\ProductCatalogue;
use App\Models\Review;
use Auth;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Log;
use Validator;


class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCatalogue::where('publish', 1)
            ->where('parent_id', 0)
            ->with([
                'children' => function ($query) {
                    $query->where('publish', 1)->orderBy('name', 'asc');
                }
            ])
            ->orderBy('name', 'asc')
            ->get();

        $productsQuery = Product::query()->where('publish', 1);

        $selectedCategoryId = $request->query('category');
        $filterType = $request->query('type');
        $selectedCategory = null;
        $pageTitle = 'Tất Cả Sản Phẩm';

        if ($selectedCategoryId && is_numeric($selectedCategoryId)) {
            $selectedCategory = ProductCatalogue::find($selectedCategoryId);
            if ($selectedCategory) {
                $pageTitle = $selectedCategory->name;
                $productsQuery->where('product_catalogue_id', $selectedCategoryId);
                $filterType = null;
            } else {
                $selectedCategoryId = null;
            }
        }


        if ($filterType === 'new') {
            $pageTitle = 'Sản Phẩm Mới';
            $productsQuery->where('is_new', 1);
            $productsQuery->orderBy('created_at', 'desc');
        } elseif ($filterType === 'sale') {
            $pageTitle = 'Sản Phẩm Sale';
            $productsQuery->where('is_sale', 1);
            $productsQuery->orderBy('updated_at', 'desc');
        } elseif ($filterType === 'trend') {
            $pageTitle = 'Sản Phẩm Hot Trend';
            $productsQuery->where('is_trending', 1);
            $productsQuery->orderBy('updated_at', 'desc');
        }


        $products = $productsQuery->paginate(16)->withQueryString();


        $products = Product::with('variants')->get(); // hoặc bạn có thể thay đổi query theo ý bạn

        $colors = Attribute::where('attribute_catalogue_id', 10)->get();
        $sizes = Attribute::where('attribute_catalogue_id', 11)->get();

        return view('client.productss.productss', [
            'products' => $products,
            'pageTitle' => $pageTitle,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'selectedCategoryId' => $selectedCategoryId
        ],compact('products', 'colors', 'sizes'));
    }


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


    public function reviewProduct(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.integer' => 'Điểm đánh giá không hợp lệ.',
            'rating.min' => 'Điểm đánh giá thấp nhất là 1 sao.',
            'rating.max' => 'Điểm đánh giá cao nhất là 5 sao.',
            'comment.string' => 'Bình luận phải là dạng văn bản.',
            'comment.max' => 'Bình luận không được vượt quá 1000 ký tự.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_scroll', '#reviews');
        }


        // $existingReview = Review::where('user_id', Auth::id())
        //     ->where('product_id', $product->id)
        //     ->first();
        // if ($existingReview) {
        //     return redirect()->route('client.product.show', $product->id)
        //         ->with('warning', 'Bạn đã đánh giá sản phẩm này rồi.');
        // }


        try {
            Review::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
            ]);

            $redirectUrl = route('client.product.show', $product->id) . '#reviews';

            return redirect($redirectUrl)->with('success', 'Cảm ơn bạn đã gửi đánh giá!');

        } catch (\Exception $e) {
            Log::error("Error saving review: " . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi khi gửi đánh giá. Vui lòng thử lại.')
                ->withInput()
                ->with('error_scroll', '#reviews');
        }
    }

}

