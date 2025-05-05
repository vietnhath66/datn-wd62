<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Order;
use App\Models\ProductGallery;
use App\Repositories\OrderRepository;
use App\Services\Interfaces\OrderServiceInterface;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\BaseService;
use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductReponsitory;
use App\Repositories\Interfaces\OrderRepositoryInterface as orderReponsitory;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterReponsitory;
use App\Repositories\Interfaces\ProductVariantLanguageReponsitoryInterface as ProductVariantLanguageReponsitory;
use App\Repositories\Interfaces\ProductVariantAttributeReponsitoryInterface as ProductVariantAttributeReponsitory;
use App\Repositories\Interfaces\PromotionReponsitoryInterface as PromotionReponsitory;
use App\Repositories\Interfaces\AttributeReponsitoryInterface as AttributeReponsitory;
use App\Repositories\Interfaces\AttributeCatalogueReponsitoryInterface as AttributeCatalogueReponsitory;
// use App\Repositories\Interfaces\OrderReponsitoryInterface as orderReponsitory;

use Illuminate\Support\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;


/**
 * Class ProductService
 * @package App\Services
 */
class OrderService extends BaseService implements OrderServiceInterface
{

    const PATH_UPLOAD = 'Orders';
    protected $model;
    protected $productReponsitory;
    protected $orderReponsitory;
    protected $routerReponsitory;
    protected $productVariantLanguageReponsitory;
    protected $productVariantAttributeReponsitory;
    protected $PromotionReponsitory;
    protected $AttributeReponsitory;
    protected $AttributeCatalogueReponsitory;
    protected $ProductCatalogueService;

    public function __construct(
        Order $model,
        ProductReponsitory $productReponsitory,
        OrderRepository $orderReponsitory,
        // RouterReponsitory $routerReponsitory,
        // ProductVariantLanguageReponsitory $productVariantLanguageReponsitory,
        ProductVariantAttributeReponsitory $productVariantAttributeReponsitory,
        // PromotionReponsitory $PromotionReponsitory,
        AttributeReponsitory $AttributeReponsitory,
        AttributeCatalogueReponsitory $AttributeCatalogueReponsitory,
        ProductCatalogueService $ProductCatalogueService,
    ) {
        $this->model = $model;
        $this->productReponsitory = $productReponsitory;
        $this->orderReponsitory = $orderReponsitory;
        // $this->productVariantLanguageReponsitory = $productVariantLanguageReponsitory;
        $this->productVariantAttributeReponsitory = $productVariantAttributeReponsitory;
        // $this->routerReponsitory = $routerReponsitory;
        // $this->PromotionReponsitory = $PromotionReponsitory;
        $this->AttributeReponsitory = $AttributeReponsitory;
        $this->AttributeCatalogueReponsitory = $AttributeCatalogueReponsitory;
        $this->ProductCatalogueService = $ProductCatalogueService;
        $this->controllerName = 'OrderController';
    }

    
    public function paginates($request, $modelCatalogue = null, $page = 1, $extend = [])
    {
        if (!is_null($modelCatalogue)) {
            Paginator::currentPageResolver(function () use ($page) {
                return $page;
            });
        }

        $perPage = $request->integer('perpage') ?: 5;
        $keyword = addslashes($request->input('keyword'));

        

        $orders = Order::selectRaw("
        orders.id,
        MAX(orders.user_id) as user_id,
        MAX(users.name) as customer_name,
        MAX(orders.email) as email,
        MAX(orders.phone) as phone,
        MAX(orders.total) as total,
        MAX(orders.status) as status,
        MAX(orders.payment_status) as payment_status,
        MAX(orders.payment_method) as payment_method,
        MAX(orders.neighborhood) as neighborhood,
        MAX(orders.barcode) as barcode,
        MAX(orders.province) as province,
        MAX(orders.district) as district,
        MAX(orders.number_house) as number_house,
        MAX(orders.address) as address,
        MAX(orders.created_at) as created_at,
        MAX(orders.updated_at) as updated_at
    ")
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('orders.id', 'like', "%{$keyword}%");
            })
            ->groupBy('orders.id')
            ->orderBy('orders.id', 'DESC')
            ->paginate($perPage);


        // Load quan hệ sau khi lấy dữ liệu
        $orders->load(['orderItems.products.product_variants']);

        return $orders;
    }

    public function edit($id)
    {
        // Lấy thông tin đơn hàng theo ID
        $order = Order::selectRaw("
            orders.id,
            orders.user_id,
            users.name as customer_name,
            orders.email,
            orders.phone,
            orders.total,
            orders.status,
            orders.payment_status,
            orders.payment_method,
            orders.neighborhood,
            orders.barcode,
            orders.province,
            orders.district,
            orders.number_house,
            orders.address,
            orders.created_at,
            orders.updated_at
        ")
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->where('orders.id', $id)
            ->first(); // Chỉ lấy 1 đơn hàng theo ID

        if (!$order) {
            return redirect()->route('admin.order.index')->with('error', 'Đơn hàng không tồn tại');
        }

        // Load thêm thông tin chi tiết đơn hàng (sản phẩm)
        $order->load(['orderItems.products.product_variants']);

        return view('admin.orders.store', compact('order'));
    }

    // public function update($id, Request $request){
    //     $order = Order::find($id);
    //     if (!$order) {
    //         return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không tồn tại');
    //     }

    //     // Cập nhật thông tin đơn hàng
    //     $order->update($request->only([
    //         'email', 'phone', 'status', 'payment_status', 'total_discount', 'address_detail'
    //     ]));

    //     // Cập nhật sản phẩm trong đơn hàng nếu cần
    //     if ($request->has('order_items')) {
    //         foreach ($request->order_items as $item) {
    //             $orderItem = OrderItem::find($item['id']);
    //             if ($orderItem) {
    //                 $orderItem->update([
    //                     'quantity' => $item['quantity'],
    //                     'price' => $item['price']
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect()->route('admin.orders.index')->with('success', 'Cập nhật đơn hàng thành công');
    // }


    // public function update($id, $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $product = $this->uploadProduct($id, $request);
    //         if ($product) {

    //             $product->product_variants()->each(function ($variant) {
    //                 $variant->attributes()->detach();
    //                 $variant->delete();
    //             });
    //             if ($request->input('attribute')) {
    //                 $this->createVariant($product, $request);
    //                 // dd($product);
    //             }
    //             // $this->ProductCatalogueService->setAttribute($product);
    //         }
    //         DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         // Log::error($e->getMessage());
    //         echo $e->getMessage();
    //         die();
    //         return false;
    //     }
    // }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = $this->productReponsitory->findById($id);

            $deleteProduct = $this->productReponsitory->destroy($product);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }

    private function createProduct($request)
    {
        $payload = $request->only($this->payload());
        if ($request->hasFile('image')) {
            $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $payload['price'] = (float) $payload['price'];
        $payload['attributeCatalogue'] = $this->formatJson($request, 'attributeCatalogue');
        $payload['attribute'] = $request->input('attribute');
        $payload['variant'] = $this->formatJson($request, 'variant');
        $payload['publish'] == "on" ? $payload['publish'] = 1 : $payload['publish'] = 0;
        // $payload['is_active'] == "on" ? $payload['publish'] = 1 : $payload['publish'] = 0;
        $payload['is_sale'] == "on" ? $payload['is_sale'] = 1 : $payload['is_sale'] = 0;
        $payload['is_new'] == "on" ? $payload['is_new'] = 1 : $payload['is_new'] = 0;
        $payload['is_trending'] == "on" ? $payload['is_trending'] = 1 : $payload['is_trending'] = 0;
        $payload['is_show_home'] == "on" ? $payload['is_show_home'] = 1 : $payload['is_show_home'] = 0;

        // dd($payload);

        $product = $this->productReponsitory->create($payload);
        // $this->createProductGallery($product->id, $request);
        return $product;
    }

    private function createProductGallery($productId, $request)
    {
        $dataProductGalleries = $request->product_galleries ?: [];

        foreach ($dataProductGalleries as $image) {
            ProductGallery::query()->create([
                'product_id' => $productId,
                'image' => Storage::put(self::PATH_UPLOAD, $image)
            ]);
        }

        return true;
    }

    private function uploadProduct($id, $request)
    {
        $payload = $request->only($this->payload());

        $product = $this->productReponsitory->findById($id);

        if ($request->hasFile('image')) {
            $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $currentImage = $product->image;

        if ($request->hasFile('image') && $currentImage && Storage::exists($currentImage)) {
            Storage::delete($currentImage);
        }
        $payload['price'] = (float) $payload['price'];
        $payload['attributeCatalogue'] = $this->formatJson($request, 'attributeCatalogue');
        $payload['attribute'] = $request->input('attribute');
        $payload['variant'] = $this->formatJson($request, 'variant');
        $payload['publish'] == "on" ? $payload['publish'] = 1 : $payload['publish'] = 0;
        // $payload['is_active'] == "on" ? $payload['publish'] = 1 : $payload['publish'] = 0;
        $payload['is_sale'] == "on" ? $payload['is_sale'] = 1 : $payload['is_sale'] = 0;
        $payload['is_new'] == "on" ? $payload['is_new'] = 1 : $payload['is_new'] = 0;
        $payload['is_trending'] == "on" ? $payload['is_trending'] = 1 : $payload['is_trending'] = 0;
        $payload['is_show_home'] == "on" ? $payload['is_show_home'] = 1 : $payload['is_show_home'] = 0;

        return $this->productReponsitory->update($id, $payload);
    }

    private function updateLanguageForProduct($product, $request, $languageId)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload = $this->formatLanguagePayload($payload, $product->id, $languageId);

        // $locale = app()->getLocale();
        // $language = Language::where('canonical', $locale)->first();
        // dd($this->currenLanguage());

        $product->languages()->detach([$this->currenLanguage(), $product->id]);
        return $this->productReponsitory->createPivot($product, $payload, 'languages');
    }

    private function updateCatalogueForProduct($product, $request)
    {
        $product->product_catalogues()->sync($this->catalogue($request));
    }

    private function formatLanguagePayload($payload, $productId, $languageId)
    {
        $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] = $languageId;
        $payload['product_id'] = $productId;
        return $payload;
    }

    // private function formatJson($request, $inputName)
    // {
    //     return ($request->input($inputName) && !empty($request->input($inputName))) ? json_encode($request->input($inputName)) : '';
    // }


    private function catalogue($request)
    {
        if ($request->input('catalogue') != null) {
            return array_unique(array_merge($request->input('catalogue'), [$request->product_catalogue_id]));
        }
        return [$request->product_catalogue_id];
    }

    public function updateStatus($post = [])
    {
        $product = $this->productReponsitory->findById($post['modelId']);
        // dd($product);
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1) ? 2 : 1);
            $post = $this->productReponsitory->update($product, $payload);
            // $this->changeUserStatus($post, $payload[$post['field']]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            dd($post);

            $payload[$post['field']] = $post['value'];
            $flag = $this->productReponsitory->updateByWhereIn('id', $post['id'], $payload);
            // $this->changeUserStatus($post, $post['value']);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }

    private function whereRaw($request, $order_item = null)
    {
        $rawCondition = [];
        if ($request->integer('order_item') > 0 || !is_null($order_item)) {
            $catId = ($request->integer('order_item') > 0) ? $request->integer('order_item') : $order_item->id;
            $rawCondition['whereRaw'] = [
                [
                    'order_item.id IN (
                       SELECT id
                        FROM order_item
                        JOIN product ON order_item.id = product.id
                        JOIN product_variant ON order_item.id = product_variant.product_variant_id
                        WHERE 1;
                    )',
                    [$catId, $catId]
                ]
            ];
        }
        return $rawCondition;
    }

    private function createVariant($product, $request)
    {
        $payload = $request->only(['variant', 'productVariant', 'attribute']);
        $variant = $this->createVariantArray($payload, $product);
        $product->product_variants()->delete();
        $varriants = $product->product_variants()->createMany($variant);
        $variantId = $varriants->pluck('id');

        $variantAttribute = [];
        $attributeCombines = $this->combineAttributes(array_values($payload['attribute']));
        if (count($variantId)) {
            foreach ($variantId as $key => $val) {
                if (count($attributeCombines)) {
                    foreach ($attributeCombines[$key] as $attributeId) {
                        $variantAttribute[] = [
                            'product_variant_id' => $val,
                            'attribute_id' => $attributeId
                        ];
                    }
                }
            }
        }
        // dd($variantAttribute);
        $variantAttributes = $this->productVariantAttributeReponsitory->createBatch($variantAttribute);
    }

    public function combineAttributes(array $attribute = [], $index = 0)
    {
        if ($index === count($attribute))
            return [[]];

        $subCombines = $this->combineAttributes($attribute, $index + 1);
        $combines = [];

        foreach ($attribute[$index] as $key => $val) {
            foreach ($subCombines as $keySub => $valSub) {
                $combines[] = array_merge([$val], $valSub);
            }
        }

        return $combines;
    }

    private function createVariantArray(array $payload = [], $product): array
    {
        // dd($payload);

        $variant = [];
        if (isset($payload['variant']['sku']) && count($payload['variant']['sku'])) {
            foreach ($payload['variant']['sku'] as $key => $val) {

                // $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, $product->id . ', ' . $payload['productVariant']['id'][$key]);
                $vId = ($payload['productVariant']['id'][$key]) ?? '';
                $productVariantId = $this->sortString($vId);
                $variant_details = explode(",", $payload['productVariant']['name'][$key]);
                // $array = explode(",", $str);
                $variant[] = [
                    // 'name' => $product->name . " " . $payload['productVariant']['name'][$key],
                    'name' => $product->name,
                    'name_variant_size' => $variant_details[0],
                    'name_variant_color' => $variant_details[1],
                    'code' => $productVariantId,
                    'quantity' => ($payload['variant']['quantity'][$key]) ?? '',
                    'sku' => $val,
                    'price' => ($payload['variant']['price'][$key]) ? $this->convert_price($payload['variant']['price'][$key]) : '',
                    'publish' => 1,
                    // 'file_name' => ($payload['variant']['file_name'][$key]) ?? '',
                    // 'file_url' => ($payload['variant']['file_url'][$key]) ?? '',
                    // 'album' => ($payload['variant']['album'][$key]) ?? '',
                    // 'user_id' => Auth::user()->id
                ];
            }
        }
        // dd($payload['productVariant']);
        // dd($variant);
        return $variant;
    }

    public function filter($request)
    {
        $perpage = $request->input('perpage');

        $param['priceQuery'] = $this->priceQuery($request);
        $param['attributeQuery'] = $this->attributeQuery($request);
        $param['rateQuery'] = $this->rateQuery($request);
        $param['productCatalogueQuery'] = $this->productCatalogueQuery($request);

        $query = $this->combineFilterQuery($param);

        $products = $this->productReponsitory->filter($query, $perpage);

        return $products;
    }

    private function combineFilterQuery($param)
    {
        $query = [];
        foreach ($param as $array) {
            foreach ($array as $key => $value) {
                if (!isset($query[$key])) {
                    $query[$key] = [];
                }

                if (is_array($value)) {
                    $query[$key] = array_merge($query[$key], $value);
                } else {
                    $query[$key][] = $value;
                }
            }
        }

        return $query;
    }

    private function sortString(string $string = '')
    {
        $extract = explode(',', $string);
        $extract = array_map('trim', $extract);
        sort($extract, SORT_NUMERIC);
        $newArray = implode(',', $extract);
        return $newArray;
    }

    public function priceQuery($request)
    {
        $price = $request->input('price');
        $priceMin = convert_price($price['price_min']);
        $priceMax = convert_price($price['price_max']);
        $query['select'] = null;
        $query['join'] = null;
        $query['where'] = null;

        if ($priceMax > $priceMin) {
            $query['join'] = [
                ['promotion_product_variant as ppv', 'ppv.product_id', '=', 'products.id'],
                ['promotions', 'ppv.promotion_id', '=', 'promotions.id'],
            ];

            $query['select'] = "
                (products.price - MAX(
                    IF(promotions.maxDiscountValue != 0,
                        LEAST(
                            CASE 
                                WHEN discountType = 'cash' THEN discountValue
                                WHEN discountType = 'percent' THEN products.price * discountValue/100
                            ELSE 0
                            END,
                            promotions.maxDiscountValue
                        ),
                        CASE 
                            WHEN discountType = 'cash' THEN discountValue
                            WHEN discountType = 'percent' THEN products.price * discountValue / 100
                        ELSE 0
                        END
                    )
                )) as discounted_price";
            $query['groupBy'] = ['products.id', 'products.price', 'products.image', 'pv.price', 'pv.sku'];
            $query['having'] = function ($query) use ($priceMin, $priceMax) {
                $query->havingRaw('discounted_price >= ? AND discounted_price <= ?', [$priceMin, $priceMax]);
            };
        }

        return $query;
    }

    public function attributeQuery($request)
    {
        $attributes = $request->input('attributes');
        $query['select'] = null;
        $query['join'] = null;
        $query['where'] = null;

        if (!is_null($attributes) && count($attributes)) {
            $query['select'] = 'pv.price as variant_price, pv.sku as variant_sku';

            $query['join'] = [
                ['product_variants as pv', 'pv.product_id', '=', 'products.id']
            ];

            foreach ($attributes as $key => $attribute) {
                $joinKey = 'tb' . $key;
                $query['join'][] = ["product_variant_attribute as {$joinKey}", "$joinKey.product_variant_id", "=", "pv.id"];
                $query['where'][] = function ($query) use ($joinKey, $attribute) {
                    foreach ($attribute as $attr) {
                        $query->orWhere("$joinKey.attribute_id", "=", $attr);
                    }
                };
            }
        }

        return $query;
    }

    private function rateQuery($request)
    {
        $rates = $request->input('rate');
        // $query['select'] = null;
        $query['join'] = null;
        $query['having'] = null;

        if (!is_null($rates) && count($rates)) {
            $query['join'] = [
                ['reviews', 'reviews.reviewable_id', '=', 'products.id']
            ];
            $rateCondition = [];
            $bindings = [];

            foreach ($rates as $rate) {
                if ($rate != 5) {
                    $minRate = $rate . '.1';
                    $maxRate = $rate . '.9';
                    $rateCondition[] = '(AVG(reviews.score) >= ? AND AVG(reviews.score) <= ?)';
                    $bindings[] = $minRate;
                    $bindings[] = $maxRate;
                } else {
                    $rateCondition[] = 'AVG(reviews.score) = ?';
                    $bindings[] = 5;
                }
            }
            $query['where'] = function ($query) {
                $query->where('reviews.reviewable_type', '=', 'App\\Models\\Product');
            };
            $query['having'] = function ($query) use ($rateCondition, $bindings) {
                $query->havingRaw(implode(' OR ', $rateCondition), $bindings);
            };
        }

        return $query;
    }


    public function orderStatistic($monthChoose)
    {
        $month = now()->month;
        $year = now()->year;
        $previousMoth = ($month == 1) ? 12 : $month - 1;
        $previousYear = ($month == 1) ? $year - 1 : $year;

        $orderCurrentMonth = $this->orderReponsitory->getOrderByTime($month, $year, $previousMoth, $previousYear);
        $orderPreviousMonth = $this->orderReponsitory->getOrderByTime($previousMoth, $previousYear);
        return [
            'orderCurrentMonth' => $orderCurrentMonth,
            'orderPreviousMonth' => $orderPreviousMonth,
            'grow' => $this->growth($orderCurrentMonth, $orderPreviousMonth),
            'totalOrders' => $this->orderReponsitory->getTotalOrders(),
            'totalCancelOrders' => $this->orderReponsitory->getCancelOrders(),
            'revenueOrders' => $this->orderReponsitory->revenueOrders(),
            'revenueChartYear' => $this->convaertRevenueChartData($this->orderReponsitory->revenueByYear($year)),
            'revenueChartWeek' => $this->convertChartDataDay($this->orderReponsitory->revenue7Day($year)),
            'revenueChartMonth' => $this->orderReponsitory->revenueByMonth($monthChoose),
            'revenueChartWeek' => $this->orderReponsitory->lastMonth(),
            'revenueCurrentMonthTotal' => $this->orderReponsitory->revenueCurrentMonthTotal(),
            'revenueCurrentMonthOrder' => $this->orderReponsitory->revenueCurrentMonthOrder()
        ];
    }

    private function convaertRevenueChartData($chartData, $data = 'monthly_revenue', $label = 'month', $text= 'Tháng ')
    {
        $newArray = [];
        if(!is_null($chartData)) {
            foreach ($chartData as $key => $val) {
                $newArray['data'][] = $val->{$data};
                $newArray['label'][] = $text.' '.$val->{$label};

            }
        }
        return $newArray;
    }

    private function convertChartDataDay($chartData, $data = 'daily_revenue', $label = 'date', $text= 'Ngày')
    {
        $newArray = [];
        if(!is_null($chartData)) {
            foreach ($chartData as $key => $val) {
                $newArray['data'][] = $val->{$data};
                $newArray['label'][] = $text.' '.$val->{$label};

            }
        }
        return $newArray;
    }

    private function growth($currentValue, $previousValue)
    {
        $division = ($previousValue == 0) ? 1 : $previousValue;
        $grow = ($currentValue - $previousValue) / $division * 100;

        return number_format($grow, 1);
    }

    private function productCatalogueQuery($request)
    {
        $productCatalogueId = $request->input('productCatalogueId');
        $query['join'] = null;
        $query['whereRaw'] = null;
        $query['where'] = function ($query) use ($productCatalogueId) {
            $query->where('products.product_catalogue_id', '=', $productCatalogueId);
        };
        // if($productCatalogueId > 0) {
        //     $query['join'] = [
        //         ['product_catalogue_product as pcp', 'pcp.product_id', '=', 'products.id']
        //     ];
        //     $query['whereRaw'] = [
        //         'pcp.product_id IN (
        //             SELECT id
        //             FROM product_catalogues 
        //             WHERE lft >= (SELECT lft FROM product_catalogues as pc WHERE pc.id = ?)
        //             AND rgt <= (SELECT rgt FROM product_catalogues as pc WHERE pc.id = ?)
        //         )',
        //         [$productCatalogueId, $productCatalogueId]
        //     ];
        // }

        return $query;
    }


    public function ajaxOrderChart($request)
    {
        $type = $request->input('chartType');
        switch ($type) {
            case 1:
                $year = now()->year;
                $response = $this->convaertRevenueChartData($this->orderReponsitory->revenueByYear($year));
                break;
            case 7:
                $response = $this->convaertRevenueChartData($this->orderReponsitory->revenue7Day(), 'daily_revenue', 'date', 'Ngày ');
                break;
            case 30:
                $currentMonth = now()->month;
                $currentYear = now()->year;

                $dayInMonth = Carbon::createFromDate($currentYear, $currentMonth, 1)->daysInMonth;

                $allDays = range(1, $dayInMonth);

                $temp = $this->orderReponsitory->revenueCurrentMonth($currentMonth, $currentYear);

                $label = [];
                $data = [];

                $temp2 = array_map(function ($day) use ($temp, &$label, &$data) {
                    $found = collect($temp)->first(function ($record) use ($day) {
                        return $record['day'] == $day;
                    });

                    $label[] = 'Ngày ' . $day;
                    $data[] = $found ? $found['daily_revenue'] : 0;
                }, $allDays);
                $response = [
                    'label' => $label,
                    'data' => $data,
                ];
                break;
        }

        return $response;
    }


    private function paginateSelect()
    {
        return [

            'orders.id',
            'orders.user_id',
            'tb2.name as customer_name',
            'orders.email',
            'orders.phone',
            'orders.total',
            'orders.status',
            'orders.payment_status',
            'orders.payment_method',
            'orders.neighborhood',
            'orders.barcode',
            'orders.province',
            'orders.district',
            'orders.number_house',
            'orders.address',
            'orders.created_at',
            'orders.updated_at',
            'order_items.product_id',
            'products.name as product_name',
            'order_items.quantity',
            'order_items.price as product_price',
            'product_variants.name as variant_name',
            'product_variants.sku',
            'product_variants.name_variant_size',
            'product_variants.name_variant_color',
            'product_variants.price'

        ];
    }

    private function paginateSelects()
    {
        return [

            'orders.id',
            'orders.user_id',
            'customer_name',
            'orders.email',
            'orders.phone',
            'orders.total',
            'orders.status',
            'orders.payment_status',
            'orders.payment_method',
            'orders.neighborhood',
            'orders.barcode',
            'orders.province',
            'orders.district',
            'orders.number_house',
            'orders.address',
            'orders.created_at',
            'orders.updated_at',
            'order_items.product_id',
            'product_name',
            'order_items.quantity',
            'product_price',
            'variant_name',
            'product_variants.sku',
            'product_variants.name_variant_size',
            'product_variants.name_variant_color',
            'product_variants.price'

        ];
    }

    private function payload()
    {
        return [
            'name',
            'image',
            'brand_id',
            'publish',
            'description',
            'content',
            'is_active',
            'is_sale',
            'is_new',
            'is_trending',
            'is_show_home',
            'product_catalogue_id',
            'price',
            'attributeCatalogue',
            'attribute',
            'variant'
        ];
    }

    private function payloadLanguage()
    {
        return [
            'name',
            'description',
            'content',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'canonical'
        ];
    }

    function convert_price(string $price = '')
    {
        return str_replace('.', '', $price);
    }

    public function combineproductAndPromotion($productId = [], $products, $checkDuplicate = false, $flag = false)
    {
        $promotions = $this->PromotionReponsitory->finByProduct($productId);
        // dd($promotions);
        if ($flag == true) {
            $products->promotions = $promotions;
            return $products;
        }
        if ($promotions) {
            foreach ($products as $index => $product) {
                foreach ($promotions as $key => $promotion) {
                    if ($promotion->product_id == $product->id) {
                        $products[$index]->promotions = $promotion;
                    }
                }
            }
        }
        if ($checkDuplicate == false) {
            $temp = [];
            foreach ($products as $key => $val) {
                $temp[$val->id] = $val;
            }
        } else {
            $temp = $products;
        }

        return $temp;
    }

    public function getAttribute($product, $language)
    {
        // dd($product->attribute);
        if (!is_null($product->attribute)) {
            $attributeCatalogueId = array_keys($product->attribute);
            $attrCatalogues = $this->AttributeCatalogueReponsitory->getAttributeCatalogueWhereIn(
                $attributeCatalogueId,
                'attribute_catalogues.id',
                $language
            );
            $attributeId = array_merge(...$product->attribute);
            $attrs = $this->AttributeReponsitory->findAttributeByIdArray($attributeId, $language);
            if (!is_null($attrCatalogues)) {
                foreach ($attrCatalogues as $key => $val) {
                    $temAttributes = [];
                    foreach ($attrs as $attr) {
                        if ($val->id == $attr->attribute_catalogue_id) {
                            $temAttributes[] = $attr;
                        }
                    }
                    $val->attributes = $temAttributes;
                }
            }
            $product->attributeCatalogue = $attrCatalogues;
        }
        return $product;
    }

    // public function paginateIndex($productCatalogue = null) {
    //     $products = $this->productReponsitory->paginationIndex($productCatalogue);
    // }
}
