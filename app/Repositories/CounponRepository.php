<?php

namespace App\Repositories;

use App\Models\Counpon;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\CounponRepositoryInterface;

/**
 * Class UserService
 * @package App\Services
 */
class CounponRepository extends BaseRepository implements CounponRepositoryInterface
{
    protected $model;

    public function __construct(
        Counpon $model
    ){
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
    ){
        $query = $this->model->select($column)->where(function($query) use ($condition){
            if(isset($condition['keyword']) && !empty($condition['keyword'])){
                $query->where('name', 'LIKE', '%'.$condition['keyword'].'%');
            }
        });

        // if(isset($relations) && !empty($relations)){
        //     foreach($relations as $relation){
        //         $query->withCount($relation);
        //     }
        // }

        if(isset($join) && is_array($join) && count($join)){
            foreach($join as $key => $val){
                $query->join($val[0], $val[1], $val[2], $val[3]);
            }
        }

        if(isset($orderBy) && is_array($orderBy) && count($orderBy)){
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $query->paginate($perPage)->withQueryString()->withPath(env('APP_URL').$extend['path']);
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
    public function getCounponById(int $id = 0)
    {
        $counpon = $this->model->find($id);
    
        if (!$counpon) {
            throw new \Exception("Không tìm thấy khuyến mãi với ID: $id");
        }
    
        return $this->model->with('users')->findOrFail($id);
    }

}
