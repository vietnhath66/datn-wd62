<?php

namespace App\Services;

use App\Services\Interfaces\AttributeCatalogueServiceInterface;
use App\Services\BaseService;
use App\Repositories\Interfaces\AttributeCatalogueReponsitoryInterface as AttributeCatalogueReponsitory;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\RouterReponsitoryInterface as RouterReponsitory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Classes\Nestedsetbie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class AttributeCatalogueService
 * @package App\Services
 */
class AttributeCatalogueService extends BaseService implements AttributeCatalogueServiceInterface
{

    const PATH_UPLOAD = 'attribute_catalogues';
    protected $attributeCatalogueReponsitory;
    protected $routerReponsitory;
    protected $nestedset;
    protected $language;
    protected $controllerName = 'AttributeCatalogueController';


    public function __construct(
        AttributeCatalogueReponsitory $attributeCatalogueReponsitory,
        // RouterReponsitory $routerReponsitory,
    ) {
        $this->attributeCatalogueReponsitory = $attributeCatalogueReponsitory;
        // $this->routerReponsitory = $routerReponsitory;
    }

    public function paginate($request)
    {
        $perPage = $request->integer('perpage');
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
        ];
        $attributeCatalogues = $this->attributeCatalogueReponsitory->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'attribute.catalogue.index'],
            ['attribute_catalogues.lft', 'ASC'],
            [],
            []
        );

        return $attributeCatalogues;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $attributeCatalogue = $this->createCatalogue($request);
            $this->nestedset = new Nestedsetbie([
                'table' => 'attribute_catalogues',
                'foreignkey' => 'attribute_catalogue_id',
            ]);
            $this->nestedset();
            // dd($attributeCatalogue->id);
            $create = $this->updateCatalogue($attributeCatalogue, $request);
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
            $attributeCatalogue = $this->attributeCatalogueReponsitory->findById($id);
            $flag = $this->updateCatalogue($attributeCatalogue, $request);
            // if ($flag == TRUE) {
            //     $this->updateLanguageForCatalogue($attributeCatalogue, $request, $languageId);
            //     $this->nestedset = new Nestedsetbie([
            //         'table' => 'attribute_catalogues',
            //         'foreignkey' => 'attribute_catalogue_id',
            //     ]);
            //     $this->nestedset();
            // }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            // die();
            return false;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $attributeCatalogue = $this->attributeCatalogueReponsitory->destroy($id);
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
            $payload['image'] = $request->file('image')->store(self::PATH_UPLOAD, 'public');

        }
        $attributeCatalogue = $this->attributeCatalogueReponsitory->create($payload);
        return $attributeCatalogue;
    }

    private function updateCatalogue($attributeCatalogue, $request)
    {
        $payload = $request->only($this->payload());
    
        // Chỉ xử lý khi có file mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($attributeCatalogue->image && Storage::disk('public')->exists($attributeCatalogue->image)) {
                Storage::disk('public')->delete($attributeCatalogue->image);
            }
    
            // Lưu ảnh mới
            $payload['image'] = $request->file('image')->store(self::PATH_UPLOAD, 'public');
        }
    
        return $this->attributeCatalogueReponsitory->update($attributeCatalogue->id, $payload);
    }
    

    private function updateLanguageForCatalogue($attributeCatalogue, $request, $languageId)
    {
        $payload = $this->formatLanguagePayload($attributeCatalogue, $request, $languageId);
        $attributeCatalogue->languages()->detach([$languageId, $attributeCatalogue->id]);
        $language = $this->attributeCatalogueReponsitory->createPivot($attributeCatalogue, $payload, 'languages');
        return $language;
    }

    private function formatLanguagePayload($attributeCatalogue, $request, $languageId)
    {
        $payload = $request->only($this->payloadLanguage());
        // $payload['canonical'] = Str::slug($payload['canonical']);
        $payload['language_id'] =  $languageId;
        $payload['attribute_catalogue_id'] = $attributeCatalogue->id;
        return $payload;
    }


    public function nestedset()
    {
        $this->nestedset->Get('level ASC, order ASC');
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();
    }

    private function paginateSelect()
    {
        return [
            'attribute_catalogues.id',
            'attribute_catalogues.image',
            'attribute_catalogues.level',
            'attribute_catalogues.name',
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
            // 'canonical'
        ];
    }
}
