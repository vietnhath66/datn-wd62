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

    public function getAttributeCatalogueById(int $id = 0, $language_id = 0){
        return $this->model->select([
                'attribute_catalogues.id',
                'attribute_catalogues.parent_id',
                'attribute_catalogues.image',
                'attribute_catalogues.icon',
                'attribute_catalogues.album',
                'attribute_catalogues.publish',
                'attribute_catalogues.follow',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ]
        )
        ->join('attribute_catalogue_language as tb2', 'tb2.attribute_catalogue_id', '=','attribute_catalogues.id')
        ->where('tb2.language_id', '=', $language_id)
        ->find($id);
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

}
