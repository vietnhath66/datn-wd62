<?php

namespace App\Services;

use App\Http\Controllers\Backend\ProductController;
use App\Models\Language;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductVariant;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\BaseService;
use App\Services\Interfaces\ProductCatalogueServiceInterface as ProductCatalogueService;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductReponsitory;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterReponsitory;
use App\Repositories\Interfaces\ProductVariantLanguageReponsitoryInterface as ProductVariantLanguageReponsitory;
use App\Repositories\Interfaces\ProductVariantAttributeReponsitoryInterface as ProductVariantAttributeReponsitory;
use App\Repositories\Interfaces\PromotionReponsitoryInterface as PromotionReponsitory;
use App\Repositories\Interfaces\AttributeReponsitoryInterface as AttributeReponsitory;
use App\Repositories\Interfaces\AttributeCatalogueReponsitoryInterface as AttributeCatalogueReponsitory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Ramsey\Uuid\Uuid;


/**
 * Class ProductService
 * @package App\Services
 */
class ProductService extends BaseService implements ProductServiceInterface
{
    const PATH_UPLOAD = 'products';

    protected $productReponsitory;
    protected $routerReponsitory;
    protected $productVariantLanguageReponsitory;
    protected $productVariantAttributeReponsitory;
    protected $PromotionReponsitory;
    protected $AttributeReponsitory;
    protected $AttributeCatalogueReponsitory;
    protected $ProductCatalogueService;

    public function __construct(
        ProductReponsitory $productReponsitory,
        // RouterReponsitory $routerReponsitory,
        // ProductVariantLanguageReponsitory $productVariantLanguageReponsitory,
        ProductVariantAttributeReponsitory $productVariantAttributeReponsitory,
        // PromotionReponsitory $PromotionReponsitory,
        AttributeReponsitory $AttributeReponsitory,
        AttributeCatalogueReponsitory $AttributeCatalogueReponsitory,
        ProductCatalogueService $ProductCatalogueService,
    ) {
        $this->productReponsitory = $productReponsitory;
        // $this->productVariantLanguageReponsitory = $productVariantLanguageReponsitory;
        $this->productVariantAttributeReponsitory = $productVariantAttributeReponsitory;
        // $this->routerReponsitory = $routerReponsitory;
        // $this->PromotionReponsitory = $PromotionReponsitory;
        $this->AttributeReponsitory = $AttributeReponsitory;
        $this->AttributeCatalogueReponsitory = $AttributeCatalogueReponsitory;
        $this->ProductCatalogueService = $ProductCatalogueService;
        $this->controllerName = 'ProductController';
    }

    public function paginate($request, $modelCatalogue = null, $page = 1, $extend = [])
    {
        if (!is_null($modelCatalogue)) {
            Paginator::currentPageResolver(function () use ($page) {
                return $page;
            });
        }

        $perPage = $request->integer('perpage');
        $perPage = 5;
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish'),
            'where' => [],
        ];
        $paginationConfig = [
            'path' => ($extend['path']) ?? 'admin/products/product/index',
            'groupBy' => $this->paginateSelect()
        ];

        $relations = ['product_catalogues'];
        $rawQuery = $this->whereRaw($request, $modelCatalogue);
        $joins = [
            ['product_catalogues as tb2', 'products.product_catalogue_id', '=', 'tb2.id'],
        ];
        $orderBy = ['products.id', 'DESC'];
        $products = $this->productReponsitory->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            $paginationConfig,
            $orderBy,
            $joins,
            $relations,
            $rawQuery
        );

        if (isset($condition['keyword'])) {
            $products = Product::where('name', 'LIKE', '%' . $condition['keyword'] . '%')->get();
        }

        return $products;
    }

    public function create($request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $product = $this->createProduct($request);
            if ($product->id > 0) {

                if ($request->input('attribute')) {
                    $this->createVariant($product, $request);
                }
            }
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


    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $product = $this->uploadProduct($id, $request);
            if ($product) {

                $product->product_variants()->each(function ($variant) {
                    $variant->attributes()->detach();
                    $variant->delete();
                });
                if ($request->input('attribute')) {

                    $this->createVariant($product, $request);
                }
            }
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

    public function destroy($id) // Nhận $id thay vì Product $product
    {
        // $this->authorize('delete_products_ql'); // Ví dụ kiểm tra quyền bằng Gate

        DB::beginTransaction(); // Sử dụng transaction để đảm bảo tính toàn vẹn
        try {
            $product = Product::findOrFail($id); // Tìm sản phẩm bằng ID

            // Logic soft delete các thành phần liên quan (NẾU CẦN và NẾU chúng dùng SoftDeletes)
            // Ví dụ: Nếu bạn muốn soft delete cả variants và gallery khi product bị soft delete
            // Lưu ý: Nếu các bảng product_variants, product_gallery có khóa ngoại với ON DELETE CASCADE
            // và model Product dùng SoftDeletes, thì việc $product->delete() sẽ KHÔNG tự động
            // soft delete các bảng con. Bạn phải tự làm hoặc dùng package hỗ trợ cascading soft deletes.

            // Ví dụ: Soft delete variants (nếu ProductVariant model có dùng SoftDeletes trait)
            // foreach ($product->variants as $variant) {
            //     $variant->delete();
            // }

            // Ví dụ: Soft delete gallery (nếu ProductGallery model có dùng SoftDeletes trait)
            // foreach ($product->gallery as $galleryItem) {
            //     $galleryItem->delete();
            // }

            // Thực hiện soft delete cho sản phẩm chính
            // Phương thức delete() sẽ tự động cập nhật deleted_at nếu model Product dùng trait SoftDeletes
            $product->delete();

            DB::commit();
            return redirect()->route('admin.product.index')->with('success', 'Sản phẩm đã được đưa vào thùng rác.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi khi đưa sản phẩm ID {$id} vào thùng rác: " . $e->getMessage());
            return redirect()->route('admin.product.index')->with('error', 'Lỗi khi xóa sản phẩm.');
        }
    }

    /**
     * Xóa vĩnh viễn sản phẩm và các file ảnh liên quan.
     * Phương thức này nên được gọi từ một route/action riêng biệt (ví dụ: từ trang thùng rác).
     */
    public function forceDestroy($id) // Nhận $id
    {
        // $this->authorize('force_delete_products_ql'); // Ví dụ kiểm tra quyền cao hơn

        DB::beginTransaction();
        try {
            // Khi force delete, bạn cần lấy cả những bản ghi đã soft delete (nếu có)
            $product = Product::withTrashed()->findOrFail($id);

            // 1. Xóa file ảnh chính (CHỈ KHI FORCE DELETE)
            // Logic xóa file này nên được đặt trong Eloquent Event 'deleting' hoặc 'deleted' của model Product
            // và kiểm tra if ($product->isForceDeleting()) như đã hướng dẫn trước để code controller gọn hơn.
            // Tuy nhiên, nếu bạn muốn làm trực tiếp ở đây:
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
                Log::info("Đã xóa file ảnh chính: {$product->image} cho sản phẩm ID: {$product->id} khi force delete.");
            }

            // 2. Xóa các ảnh gallery liên quan (CHỈ KHI FORCE DELETE)
            // Tương tự, logic này cũng nên nằm trong event của Product hoặc ProductGallery model
            $galleries = ProductGallery::where('product_id', $product->id)->get(); // Lấy cả trashed nếu ProductGallery cũng soft delete
            if ($galleries->count() > 0) {
                foreach ($galleries as $gallery) {
                    if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) { // Giả sử cột lưu đường dẫn là image_path
                        Storage::disk('public')->delete($gallery->image_path);
                        Log::info("Đã xóa file ảnh gallery: {$gallery->image_path} cho sản phẩm ID: {$product->id} khi force delete.");
                    }
                    $gallery->forceDelete(); // Xóa vĩnh viễn bản ghi gallery khỏi DB
                }
            }

            // 3. Xóa các biến thể liên quan (CHỈ KHI FORCE DELETE)
            // Nếu bảng product_variants có khóa ngoại với ON DELETE CASCADE đến products,
            // thì khi product bị forceDelete(), các variant sẽ tự động bị xóa khỏi DB.
            // Nếu không có ON DELETE CASCADE, hoặc bạn muốn trigger event của variant (ví dụ để xóa ảnh của variant):
            // $product->variants()->withTrashed()->get()->each(function ($variant) {
            //     // Xóa ảnh của variant nếu có
            //     if ($variant->image_variant_path && Storage::disk('public')->exists($variant->image_variant_path)) {
            //         Storage::disk('public')->delete($variant->image_variant_path);
            //     }
            //     $variant->forceDelete();
            // });
            // Hoặc đơn giản hơn nếu không cần trigger event của variant và đã có ON DELETE CASCADE:
            // ProductVariant::where('product_id', $product->id)->withTrashed()->forceDelete(); // Nếu không có cascade

            // 4. Thực hiện force delete cho sản phẩm chính
            // Event 'deleted' với isForceDeleting() là true sẽ được trigger trong model Product nếu bạn đã định nghĩa.
            $product->forceDelete();

            DB::commit();
            return redirect()->route('admin.product.index') // Hoặc route về trang thùng rác
                ->with('success', 'Sản phẩm đã được xóa vĩnh viễn.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi khi xóa vĩnh viễn sản phẩm ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi khi xóa vĩnh viễn sản phẩm.');
        }
    }

    private function createProduct($request)
    {
        $payload = $request->only($this->payload());
        // if ($request->hasFile('image')) {
        //     $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        // }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/products'), $imageName);
            $payload['image'] = 'products/' . $imageName;
        }

        $payload['price'] = (float) $payload['price'];
        $payload['attributeCatalogue'] = $this->formatJson($request, 'attributeCatalogue');
        $payload['attribute'] = $request->input('attribute');
        $payload['variant'] = $this->formatJson($request, 'variant');
        if (isset($payload['publish'])) {
            $payload['publish'] == "on" ? $payload['publish'] = 1 : $payload['publish'] = 0;
        }
        if (isset($payload['is_sale'])) {
            $payload['is_sale'] == "on" ? $payload['is_sale'] = 1 : $payload['is_sale'] = 0;
        }
        if (isset($payload['is_new'])) {
            $payload['is_new'] == "on" ? $payload['is_new'] = 1 : $payload['is_new'] = 0;
        }
        if (isset($payload['is_trending'])) {
            $payload['is_trending'] == "on" ? $payload['is_trending'] = 1 : $payload['is_trending'] = 0;
        }
        if (isset($payload['is_show_home'])) {
            $payload['is_show_home'] == "on" ? $payload['is_show_home'] = 1 : $payload['is_show_home'] = 0;
        }

        $product = $this->productReponsitory->create($payload);

        $dataProductGalleries = $request->product_galleries ?: [];

        foreach ($dataProductGalleries as $image) {
            ProductGallery::query()->create([
                'product_id' => $product->id,
                'image' => $payload['image'] = 'products/' . $imageName
            ]);
        }
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
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/products'), $imageName);
            $payload['image'] = 'products/' . $imageName;
        }

        $currentImage = $product->image;


        if ($currentImage && file_exists(public_path('storage/' . $currentImage))) {
            unlink(public_path('storage/' . $currentImage));
        }

        $payload['price'] = (float) $payload['price'];
        $payload['attributeCatalogue'] = $this->formatJson($request, 'attributeCatalogue');
        $payload['attribute'] = $request->input('attribute');
        $payload['variant'] = $this->formatJson($request, 'variant');
        if (isset($payload['publish'])) {
            $payload['publish'] == "on" ? $payload['publish'] = 1 : $payload['publish'] = 0;
        }

        if (isset($payload['is_sale'])) {
            $payload['is_sale'] == "on" ? $payload['is_sale'] = 1 : $payload['is_sale'] = 0;
        }
        if (isset($payload['is_new'])) {
            $payload['is_new'] == "on" ? $payload['is_new'] = 1 : $payload['is_new'] = 0;
        }
        if (isset($payload['is_trending'])) {
            $payload['is_trending'] == "on" ? $payload['is_trending'] = 1 : $payload['is_trending'] = 0;
        }
        if (isset($payload['is_show_home'])) {
            $payload['is_show_home'] == "on" ? $payload['is_show_home'] = 1 : $payload['is_show_home'] = 0;
        }
        $product = $this->productReponsitory->update($id, $payload);

        $dataProductGalleries = $request->product_galleries ?: [];

        $dataProductGalleriesPre = $request->file_product_galleries ?: "";
        $dataProductGalleriesPre = explode(',', $dataProductGalleriesPre);

        foreach ($dataProductGalleriesPre as $val) {
            $gallery = ProductGallery::where('id', '=', (int) $val)->first();
            if ($gallery) {
                $gallery->delete();
                $image = $gallery->image;
                if ($image && file_exists(public_path('storage/' . $image))) {
                    unlink(public_path('storage/' . $image));
                }
            }
        }

        foreach ($dataProductGalleries as $image) {
            ProductGallery::query()->create([
                'product_id' => $product->id,
                'image' => $payload['image'] = 'products/' . $imageName
            ]);
        }

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


    private function whereRaw($request, $productCatalogue = null)
    {
        $rawCondition = [];
        if ($request->integer('product_catalogue_id') > 0 || !is_null($productCatalogue)) {
            $catId = ($request->integer('product_catalogue_id') > 0) ? $request->integer('product_catalogue_id') : $productCatalogue->id;
            $rawCondition['whereRaw'] = [
                [
                    'tb3.id IN (
                        SELECT id
                        FROM product_catalogues
                        JOIN product_catalogue_language ON product_catalogues.id = product_catalogue_language.product_catalogue_id
                        WHERE lft >= (SELECT lft FROM product_catalogues as pc WHERE pc.id = ?)
                        AND rgt <= (SELECT rgt FROM product_catalogues as pc WHERE pc.id = ?)
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
        // dd($payload);
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
        // dd(count($payload['productVariant']));
        // dd(count(explode(",", $payload['productVariant']['name'][1])));
        $variant_details = explode(",", $payload['productVariant']['name'][0]);

        // dd($variant_details[0]);



        $variant = [];
        if (isset($payload['variant']['sku']) && count($payload['variant']['sku'])) {
            foreach ($payload['variant']['sku'] as $key => $val) {
                $vId = ($payload['productVariant']['id'][$key]) ?? '';
                $productVariantId = $this->sortString($vId);
                $variant_details = explode(",", $payload['productVariant']['name'][$key]);
                if (count($variant_details) != 2) {
                    if (mb_strlen($variant_details[0]) > 1 || $variant_details[0] != 'xl' || $variant_details[0] != 'xxl') {
                        $variant[] = [
                            'name' => $product->name,
                            'name_variant_size' => '',
                            'name_variant_color' => $variant_details[0],
                            'sku' => ($payload['variant']['sku'][$key]) ?? '',
                            'code' => $productVariantId,
                            'quantity' => ($payload['variant']['quantity'][$key]) ?? '',
                            'price' => ($payload['variant']['price'][$key]) ? $this->convert_price($payload['variant']['price'][$key]) : '',
                            'publish' => 1,
                        ];
                    } else {
                        $variant[] = [
                            'name' => $product->name,
                            'name_variant_size' => $variant_details[0],
                            'name_variant_color' => '',
                            'code' => $productVariantId,
                            'sku' => ($payload['variant']['sku'][$key]) ?? '',
                            'quantity' => ($payload['variant']['quantity'][$key]) ?? '',
                            'price' => ($payload['variant']['price'][$key]) ? $this->convert_price($payload['variant']['price'][$key]) : '',
                            'publish' => 1,
                        ];
                    }
                } else {
                    if (mb_strlen($variant_details[0]) == 1 || $variant_details[0] == 'xl' || $variant_details[0] == 'xxl') {
                        $variant[] = [
                            'name' => $product->name,
                            'name_variant_size' => $variant_details[0],
                            'name_variant_color' => $variant_details[1],
                            'code' => $productVariantId,
                            'sku' => ($payload['variant']['sku'][$key]) ?? '',
                            'quantity' => ($payload['variant']['quantity'][$key]) ?? '',
                            'price' => ($payload['variant']['price'][$key]) ? $this->convert_price($payload['variant']['price'][$key]) : '',
                            'publish' => 1,
                        ];
                    } else {
                        $variant[] = [
                            'name' => $product->name,
                            'name_variant_size' => $variant_details[1],
                            'name_variant_color' => $variant_details[0],
                            'code' => $productVariantId,
                            'sku' => ($payload['variant']['sku'][$key]) ?? '',
                            'quantity' => ($payload['variant']['quantity'][$key]) ?? '',
                            'price' => ($payload['variant']['price'][$key]) ? $this->convert_price($payload['variant']['price'][$key]) : '',
                            'publish' => 1,
                        ];
                    }
                }
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

    private function paginateSelect()
    {
        return [
            'products.id',
            'products.publish',
            'products.name',
            'products.image',
            'products.price',
            // 'tb2.name AS catalogue_name'

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
