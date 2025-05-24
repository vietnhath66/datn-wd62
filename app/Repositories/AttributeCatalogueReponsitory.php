<?php

namespace App\Repositories;

use App\Models\AttributeCatalogue;
use App\Repositories\Interfaces\AttributeCatalogueReponsitoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class AttributeCatalogueReponsitory extends BaseRepository implements AttributeCatalogueReponsitoryInterface
{
    protected $model;

    public function __construct(
        AttributeCatalogue $model
    ){
        $this->model = $model;
    }
    
    public function getAttributeCatalogueById(int $id = 0) {
        return $this->model->select([
                'id',
                'parent_id',
                'lft',
                'rgt',
                'level',
                'image',
                'name',
                'description',
                'content',
                'deleted_at',
                'created_at',
                'updated_at',
            ])
            ->where('id', $id)
            ->first();
    }
    
    public function getAll(int $languageId = 0){
        // dd( $this->model->with(['attribute_catalogue_language' => function($query) use ($languageId){
        //     // $query->where('language_id', $languageId);
        // }, ])->get());
        return $this->model->with(['attribute_catalogue_language' => function($query) use ($languageId){
            // $query->where('language_id', $languageId);
        }, ])->get();

    }

    public function getAttributeCatalogueWhereIn($whereIn = [], $whereInField = 'id', $language){
        return $this->model->select([
            'attribute_catalogues.id',
            'tb2.name',
        ])
        ->join('attribute_catalogue_language as tb2', 'tb2.attribute_catalogue_id', '=','attribute_catalogues.id')
        ->where('tb2.language_id', '=', $language)
        ->where([config('apps.general.defaultPublish')])
        ->whereIn( $whereInField, $whereIn)
        ->get();
    }
    public function destroy($model)
    {
        if (!$model instanceof Model) {
            $model = $this->model->find($model); // Nếu truyền ID, tìm Model
        }
    
        if (!$model) {
            return false; // Nếu không tìm thấy, trả về false
        }
    
        return $model->delete();
    }
}
