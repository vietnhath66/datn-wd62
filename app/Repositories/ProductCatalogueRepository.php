<?php

namespace App\Repositories;

use App\Models\ProductCatalogue;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class ProductCatalogueRepository extends BaseRepository implements ProductCatalogueRepositoryInterface
{
    protected $model;

    public function __construct(
        ProductCatalogue $model
    ) {
        $this->model = $model;
    }

    public function getAll()
    {
        $categories = $this->model::with('children:id,name,parent_id')
            ->select('id as category_id', 'name as category_name', 'parent_id')
            ->get();
        // dd($categories);
        return $categories;
    }

    public function getProductCatalogueById(int $id = 0)
    {
        return $this->model->select(
            [
                'id',
                'image',
                'name',
                'content',
                'description',
                'parent_id',
                'lft',
                'rgt',
                'level',
            ]
        )->find($id);
    }
}
