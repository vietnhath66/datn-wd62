<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use App\Repositories\BaseRepository;

/**
 * Class UserService
 * @package App\Services
 */
class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    protected $model;

    public function __construct(
        Brand $model
    ) {
        $this->model = $model;
    }

    public function pagination(
        array $column = ['*'],
        array $condition = [],
        int $perPage = 5,
        array $extend = [],
        array $orderBy = ['id', 'DESC'],
        array $join = [],
        array $relations = [],
        array $whereRaw = [],
    ) {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%');
            }
        });

        // if(isset($relations) && !empty($relations)){
        //     foreach($relations as $relation){
        //         $query->withCount($relation);
        //     }
        // }

        if (isset($join) && is_array($join) && count($join)) {
            foreach ($join as $key => $val) {
                $query->join($val[0], $val[1], $val[2], $val[3]);
            }
        }

        if (isset($orderBy) && is_array($orderBy) && count($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $query->paginate($perPage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }

    public function destroy($model)
    {
        if (!$model instanceof Model) {
            $model = $this->model->find($model); // Nếu truyền ID, tìm Model
        }


        $imagePath = public_path('storage/' . $model->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        if (!$model) {
            return false; // Nếu không tìm thấy, trả về false
        }

        return $model->delete();
    }



    public function getBrandById(int $id = 0)
    {
        $brand = $this->model->find($id);

        if (!$brand) {
            throw new \Exception("Không tìm thấy thương hiệu với ID: $id");
        }

        return $brand;
    }


}
