<?php

namespace App\Services;

use App\Services\Interfaces\ProductCatalogueServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface as ProductCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterReponsitory;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface as AttributeCatalogueReponsitory;
use App\Repositories\Interfaces\AttributeRepositoryInterface as AttributeReponsitory;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Classes\Nestedsetbie;
use App\Models\ProductCatalogue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class ProductCatalogueService
 * @package App\Services
 */
class ProductCatalogueService extends BaseService implements ProductCatalogueServiceInterface
{
    const PATH_UPLOAD = 'product_catalogues';

    protected $ProductCatalogueRepository;
    protected $AttributeCatalogueReponsitory;
    protected $AttributeReponsitory;
    // protected $routerReponsitory;
    protected $nestedset;
    protected $language;
    protected $controllerName = 'ProductCatalogueController';


    public function __construct(
        ProductCatalogueRepository $ProductCatalogueRepository,
        // RouterReponsitory $routerReponsitory,
        // AttributeCatalogueReponsitory $AttributeCatalogueReponsitory,
        // AttributeReponsitory $AttributeReponsitory,

    ) {
        $this->ProductCatalogueRepository = $ProductCatalogueRepository;
        // $this->routerReponsitory = $routerReponsitory;
        // $this->AttributeCatalogueReponsitory = $AttributeCatalogueReponsitory;
        // $this->AttributeReponsitory = $AttributeReponsitory;
    }

    public function getAll()
    {
        return $this->ProductCatalogueRepository->getAll();
    }

    public function paginate($request)
    {
        $perPage = $request->integer('perpage');
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
        ];
        // dd($condition);
        $productCatalogues = $this->ProductCatalogueRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'product.catalogue.index'],
            ['id', 'ASC'],
            [],
        );
        if(isset($condition['keyword'])){
            $productCatalogues = ProductCatalogue::where('name', 'LIKE', '%' . $condition['keyword'] . '%')->get();
        }
        return $productCatalogues;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $productCatalogue = $this->createCatalogue($request);
            $this->nestedset = new Nestedsetbie([
                'table' => 'product_catalogues',
                'foreignkey' => 'product_catalogue_id',
            ]);
            $this->nestedset();
            $create = $this->updateCatalogue($productCatalogue->id, $request);
            // dd($create);
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
            // dd($request);

            $productCatalogue = $this->ProductCatalogueRepository->findById($id);
            $this->nestedset = new Nestedsetbie([
                'table' => 'product_catalogues',
                'foreignkey' => 'product_catalogue_id',
            ]);
            $this->nestedset();
            $flag = $this->updateCatalogue($productCatalogue->id, $request);
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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $productCatalogue = $this->ProductCatalogueRepository->findById($id);
            $deleteproductCatalogue = $this->ProductCatalogueRepository->destroy($productCatalogue);
            $this->nestedset = new Nestedsetbie([
                'table' => 'product_catalogues',
                'foreignkey' => 'product_catalogue_id',
            ]);
            $this->nestedset();
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

    private function createCatalogue($request)
    {
        $payload = $request->only($this->payload());

        if ($request->hasFile('image')) {
            $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $productCatalogue = $this->ProductCatalogueRepository->create($payload);
        // dd($productCatalogue);
        return $productCatalogue;
    }

    private function updateCatalogue($productCatalogue, $request)
    {
        $payload = $request->only($this->payload());
        if ($request->hasFile('image')) {
            $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $currentImage = $request->image;

        if ($request->hasFile('image') && $currentImage && Storage::exists($currentImage)) {
            Storage::delete($currentImage);
        }

        $flag = $this->ProductCatalogueRepository->update($productCatalogue, $payload);
        return $flag;
    }

    private function updateLanguageForCatalogue($productCatalogue, $request, $languageId)
    {
        $payload = $this->formatLanguagePayload($productCatalogue, $request, $languageId);
        $productCatalogue->languages()->detach([$languageId, $productCatalogue->id]);
        $language = $this->ProductCatalogueRepository->createPivot($productCatalogue, $payload, 'languages');
        return $language;
    }

    private function formatLanguagePayload($productCatalogue, $request, $languageId)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] =  $languageId;
        $payload['product_catalogue_id'] = $productCatalogue->id;
        return $payload;
    }

    public function nestedset()
    {
        $this->nestedset->Get('level ASC, order ASC');
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();
    }

    public function setAttribute($product)
    {
        $attribute = $product->attribute;
        $productCatalogueId = (int)$product->product_catalogue_id;
        $productCatalogue = $this->ProductCatalogueRepository->findById($productCatalogueId);
        if (!is_array($productCatalogue->attribute)) {
            $payload['attribute'] = $attribute;
        } else {
            $mergeArray = $productCatalogue->attribute;
            foreach ($attribute as $key => $val) {
                if (!isset($mergeArray[$key])) {
                    $mergeArray[$key] = $val;
                } else {
                    $mergeArray[$key] = array_values(array_unique(array_merge($mergeArray[$key], $val)));
                }
            }
            $payload['attribute'] = $mergeArray;

            $flatAttributeArray = array_merge(...$mergeArray);
            $attributeList = $this->AttributeReponsitory->findAttributeproductCatalogueAndProductVariant($flatAttributeArray, $productCatalogue->id);
            $payload['attribute'] = array_map(function ($newArray) use ($attributeList) {
                return array_intersect($newArray, $attributeList->all());
            }, $mergeArray);
        }

        // dd($payload['attribute']);

        $result = $this->ProductCatalogueRepository->update($productCatalogue, $payload);


        return $result;
    }

    private function paginateSelect()
    {
        return [
            'id',
            'name',
            'image',
            'level',
            'description',
            'content',
        ];
    }

    private function payload()
    {
        return [
            'parent_id',
            'image',
            'name',
            'description',
            'content'
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
}
