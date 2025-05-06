<?php

namespace App\Services;

use App\Services\Interfaces\AttributeServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\AttributeReponsitoryInterface as AttributeReponsitory;
use App\Repositories\Interfaces\RouterReponsitoryInterface as RouterReponsitory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class AttributeService
 * @package App\Services
 */
class AttributeService extends BaseService implements AttributeServiceInterface
{
    const PATH_UPLOAD = 'attributes';

    protected $attributeReponsitory;
    protected $routerReponsitory;

    public function __construct(
        AttributeReponsitory $attributeReponsitory,
        // RouterReponsitory $routerReponsitory,
    ) {
        $this->attributeReponsitory = $attributeReponsitory;
        // $this->routerReponsitory = $routerReponsitory;
        $this->controllerName = 'AttributeController';
    }

    public function paginate($request)
    {
        $perPage = $request->integer('perpage');
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
        ];
        $paginationConfig = [
            'path' => 'attribute.index',
            'groupBy' => $this->paginateSelect()
        ];
        $orderBy = ['attributes.id', 'DESC'];
        $relations = ['attribute_catalogues'];
        $rawQuery = $this->whereRaw($request);
        // dd($rawQuery);
        $joins = [
            ['attribute_catalogue_attribute as tb2', 'attributes.id', '=', 'tb2.attribute_id'],
            ['attribute_catalogues as tb3', 'tb2.attribute_catalogue_id', '=', 'tb3.id']
        ];

        $attributes = $this->attributeReponsitory->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            $paginationConfig,
            $orderBy,
            $joins,
            $relations,
            $rawQuery
        );
        return $attributes;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $attribute = $this->createAttribute($request);
            // dd($attribute);

            if ($attribute->id > 0) {
                $this->updateCatalogueForAttribute($attribute, $request);
                // $this->createRouter($attribute, $request, $this->controllerName);
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
            $payload = $request->only($this->payload());
            $attribute = $this->attributeReponsitory->findById($id);
            // if ($this->uploadAttribute($id, $request)) {
            //     // $this->updateLanguageForAttribute($attribute, $request, $languageId);
            //     $this->updateCatalogueForAttribute($id, $request);
            //     // $this->updateRouter(
            //     //     $attribute, $request, $this->controllerName
            //     // );
            // }
            $this->updateCatalogueForAttribute($attribute, $request);
            $updateAttribute = $this->attributeReponsitory->update($id, $payload);
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

    public function destroy($attribute)
    {
        DB::beginTransaction();
        try {
            $attribute = $this->attributeReponsitory->destroy($attribute);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }

    private function createAttribute($request)
    {
        $payload = $request->only($this->payload());
        // dd($payload);
        if ($request->hasFile('image')) {
            $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }
        $attribute = $this->attributeReponsitory->create($payload);
        return $attribute;
    }

    private function uploadAttribute($attribute, $request)
    {
        $payload = $request->only($this->payload());
        if ($request->hasFile('image')) {
            $payload['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $currentImage = $attribute->image;

        if ($request->hasFile('image') && $currentImage && Storage::exists($currentImage)) {
            Storage::delete($currentImage);
        }
        return $this->attributeReponsitory->update($attribute, $payload);
    }

    private function updateLanguageForAttribute($attribute, $request, $languageId)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload = $this->formatLanguagePayload($payload, $attribute->id, $languageId);
        $attribute->languages()->detach([$this->language, $attribute->id]);
        return $this->attributeReponsitory->createPivot($attribute, $payload, 'languages');
    }

    private function updateCatalogueForAttribute($attribute, $request)
    {
        $attribute->attribute_catalogues()->sync($this->catalogue($request));
    }

    private function formatLanguagePayload($payload, $attributeId, $languageId)
    {
        $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] =  $languageId;
        $payload['attribute_id'] = $attributeId;
        return $payload;
    }


    private function catalogue($request)
    {
        if ($request->input('catalogue') != null) {
            return array_unique(array_merge($request->input('catalogue'), [$request->attribute_catalogue_id]));
        }
        // dd($request->attribute_catalogue_id);
        return [$request->attribute_catalogue_id];
    }

    private function whereRaw($request)
    {
        $rawCondition = [];
        // dd($request->integer('attribute_catalogue_id'));
        if ($request->integer('attribute_catalogue_id') > 0) {
            $attributeCatalogueId = $request->integer('attribute_catalogue_id');

            $rawCondition['whereRaw'] =  [
                [
                    'tb3.attribute_catalogue_id IN (
                        SELECT id FROM attribute_catalogues 
                        WHERE lft >= (SELECT lft FROM attribute_catalogues as pc WHERE id = ?)
                        AND rgt <= (SELECT rgt FROM attribute_catalogues as pc WHERE id = ?)
                    )',
                    [$attributeCatalogueId, $attributeCatalogueId]
                ]
            ];
        }
        return $rawCondition;
    }

    private function paginateSelect()
    {
        return [
            'attributes.id',
            'attributes.image',
            'attributes.name',
            'attributes.content',
            'attributes.description',
            'attributes.attribute_catalogue_id'
        ];
    }

    private function payload()
    {
        return [
            'image',
            'name',
            'content',
            'description',
            'attribute_catalogue_id',
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
