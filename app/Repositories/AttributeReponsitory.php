<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Repositories\Interfaces\AttributeReponsitoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class AttributeReponsitory extends BaseRepository implements AttributeReponsitoryInterface
{
    protected $model;

    public function __construct(
        Attribute $model
    ) {
        $this->model = $model;
    }



    public function getAttributeById(int $id = 0, $language_id = 0)
    {
        return $this->model->select(
            [
                'attributes.id',
                'attributes.attribute_catalogue_id',
                'attributes.image',
                'attributes.icon',
                'attributes.album',
                'attributes.publish',
                'attributes.follow',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                'tb2.canonical',
            ]
        )
            ->join('attribute_language as tb2', 'tb2.attribute_id', '=', 'attributes.id')
            ->with('attribute_catalogues')
            ->where('tb2.language_id', '=', $language_id)
            ->find($id);
    }

    public function searchAttributes(string $keyword = '', array $option = [])
    {
        return $this->model->whereHas('attribute_catalogues', function ($query) use ($option) {
            $query->where('attribute_catalogue_id', $option['attributeCatalogueId']);
        })->where('name', 'like', '%' . $keyword . '%')->get();
    }


    public function findAttributeByIdArray(array $attributeArray = []) {

        return $this->model->select([
            'id',
            'attribute_catalogue_id',
            'name'
        ])

        // ->where([config('apps.general.defaultPublish')])
        ->whereIn('attributes.id', $attributeArray)
        ->get();

    }

    public function findAttributeproductCatalogueAndProductVariant($attribuetId = [], $productCatalogueId = 0)
    {
        return $this->model->select([
            'attributes.id',
        ])
            ->leftJoin('product_variant_attribute as tb2', 'tb2.attribute_id', '=', 'attributes.id')
            ->leftJoin('product_variants as tb3', 'tb3.id', '=', 'tb2.product_variant_id')
            ->leftJoin('product_catalogue_product as tb4', 'tb4.product_id', '=', 'tb4.product_id')
            ->where('tb4.product_catalogue_id', '=', $productCatalogueId)
            ->whereIn('attributes.id', $attribuetId)
            ->distinct()
            ->pluck('attributes.id');
    }
}
