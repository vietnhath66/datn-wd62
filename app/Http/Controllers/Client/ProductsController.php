<?php

namespace App\Http\Controllers\Client;

use App\Models\Brand;
use App\Models\Order;
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
use Illuminate\Database\Eloquent\Builder;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $productsQuery = Product::query()
            ->where('publish', 1)
            ->with('variants')
            ->with('reviews')
            ->with('brands');

        $categories = ProductCatalogue::where('publish', 1)
            ->where('parent_id', 0)
            ->with([
                'children' => function ($query) {
                    $query->where('publish', 1)->orderBy('name', 'asc');
                }
            ])
            ->orderBy('name', 'asc')
            ->get();

        $productsQuery = Product::query()
            ->where('publish', 1)
            ->with('variants');


        $pageTitle = 'Tất Cả Sản Phẩm';
        $selectedCategory = null;
        $selectedCategoryId = $request->query('category');

        if ($selectedCategoryId && is_numeric($selectedCategoryId)) {
            $selectedCategory = ProductCatalogue::find($selectedCategoryId);
            if ($selectedCategory) {
                $pageTitle = $selectedCategory->name;

                Log::info('Dữ liệu $selectedCategory trước khi vào try: ' . print_r($selectedCategory->toArray(), true));
                try {
                    $parentId = $selectedCategory->getKey();

                    $descendantIds = ProductCatalogue::descendantsOf($parentId)
                        ->pluck('id')
                        ->toArray();

                    $categoryIds = array_merge([$parentId], $descendantIds);
                    $categoryIds = array_unique($categoryIds);

                    \Log::info("Danh sách ID danh mục (cha+con) cho {$selectedCategoryId} (dùng descendantsOf): " . print_r($categoryIds, true));

                } catch (\Throwable $e) {
                    Log::error("Không thể lấy danh mục con cho ID: {$selectedCategoryId} (dùng descendantsOf). Lỗi: " . $e->getMessage());
                    $categoryIds = [$selectedCategoryId];
                }


                $productsQuery->whereIn('product_catalogue_id', $categoryIds);

            } else {
                $selectedCategoryId = null;
            }
        }

        $filterType = $request->query('type');

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

        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        if (is_numeric($minPrice)) {
            $productsQuery->where('price', '>=', $minPrice);
        }
        if (is_numeric($maxPrice)) {
            $productsQuery->where('price', '<=', $maxPrice);
        }

        if ($request->has('sort')) {
            $sortParam = explode('_', $request->query('sort'));
            if (count($sortParam) == 2) {
                $sortBy = $sortParam[0];
                $sortDirection = $sortParam[1];

                $allowedSortColumns = ['name', 'price', 'created_at', 'updated_at'];
                if (in_array($sortBy, $allowedSortColumns)) {
                    $sortDirection = strtolower($sortDirection) === 'asc' ? 'asc' : 'desc';
                    $productsQuery->reorder($sortBy, $sortDirection);
                }
            }
        } elseif (!$filterType) {

            $productsQuery->orderBy('created_at', 'desc');
        }


        $selectedColors = $request->query('colors', []);
        $selectedSizes = $request->query('sizes', []);

        if (!empty($selectedColors) || !empty($selectedSizes)) {
            $productsQuery->whereHas('variants', function ($query) use ($selectedColors, $selectedSizes) {

                if (!empty($selectedColors)) {
                    $query->whereIn('product_variants.name_variant_color', $selectedColors);
                }

                if (!empty($selectedSizes)) {
                    $query->whereIn('product_variants.name_variant_size', $selectedSizes);
                }
            });
        }

        $selectedBrands = $request->query('brands', []); 
        if (!empty($selectedBrands) && is_array($selectedBrands)) {
            $validBrandIds = array_filter($selectedBrands, 'is_numeric');
            if (!empty($validBrandIds)) {
                $productsQuery->whereIn('brand_id', $validBrandIds);
            }
        }

        $selectedRatings = $request->query('ratings', []); 
        if (!empty($selectedRatings) && is_array($selectedRatings)) {
            $validRatings = array_map('intval', array_filter($selectedRatings, 'is_numeric'));
            $validRatings = array_filter($validRatings, fn($r) => $r >= 1 && $r <= 5); 

            if (!empty($validRatings)) {
                $productsQuery->whereHas('reviews', function (Builder $query) use ($validRatings) {
                    $query->whereIn('rating', $validRatings);
                });

            }
        }

        $brands = Brand::orderBy('name', 'asc')->get();

        if ($filterType) {
            $products = $productsQuery->get();
        } else {
            $products = $productsQuery->paginate(12)->withQueryString();
        }

        $colors = Attribute::where('attribute_catalogue_id', 11)->get();
        $sizes = Attribute::where('attribute_catalogue_id', 10)->get();

        $wishlistedProductIds = []; 
        if (Auth::check()) {
            $wishlistedProductIds = Auth::user()->wishlistedProducts()->pluck('products.id')->toArray();
        }

        return view('client.productss.productss', compact(
            'products',
            'pageTitle',
            'categories',
            'selectedCategory',
            'selectedCategoryId',
            'colors',
            'sizes',
            'request', 
            'brands',
            'wishlistedProductIds'
        ));
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);

        $brandId = $product->brand_id;
        $categoryId = $product->product_catalogue_id;

        $relatedProductsQuery = Product::query()
            ->where('publish', 1)
            ->where('id', '!=', $product->id);

        $relatedProductsQuery->where(function ($query) use ($brandId, $categoryId) {
            if ($brandId) {
                $query->where('brand_id', $brandId);
            }
            if ($categoryId) {
                if ($brandId) {
                    $query->orWhere('product_catalogue_id', $categoryId);
                } else {
                    $query->where('product_catalogue_id', $categoryId);
                }
            }
        });

        $relatedProducts = $relatedProductsQuery->inRandomOrder()->limit(8)->get();



        $variants = ProductVariant::where('product_id', $id)
            ->whereNull('deleted_at')
            ->get();

        $colors = $variants->pluck('name_variant_color')->unique();

        $canReview = false; 
        if (Auth::check()) { 
            $userId = Auth::id();
            $productId = $product->id;

            $canReview = Order::where('user_id', $userId)
                ->whereIn('status', ['completed', 'delivered']) 
                ->whereHas('items', function ($query) use ($productId) {
                    $query->where('product_id', $productId);
                })
                ->exists(); 
        }

        return view('client.productss.detailProducts', compact('product', 'variants', 'colors', 'relatedProducts', 'canReview'));

    }


    public function quickView($id)
    {
        $product = Product::findOrFail($id);

        $variants = ProductVariant::where('product_id', $id)
            ->whereNull('deleted_at')
            ->get();
        $ab = Product::where('product_catalogue_id', $product->product_catalogue_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(2)
            ->get();

        $colors = $variants->pluck('name_variant_color')->unique();

        return view('client.productss.detailProducts', compact('product', 'variants', 'colors', 'ab'));

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

        $userId = Auth::id(); 
        $productId = $product->id;

        $hasPurchased = Order::where('user_id', $userId)
            ->whereIn('status', ['completed', 'delivered']) 
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        if (!$hasPurchased) {
            Log::warning("Review attempt blocked: User {$userId} tried to review Product {$productId} without purchase.");
            return redirect()->back()
                ->with('error', 'Bạn cần mua sản phẩm này để có thể gửi đánh giá.')
                ->withInput() 
                ->with('error_scroll', '#reviews'); 
        }

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

