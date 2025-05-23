<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserService
 * @package App\Services
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
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
        $query = $this->model->select($column)->distinct()
            ->where(function ($query) use ($condition) {
                if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                    $query->where('users.name', 'LIKE', '%' . $condition['keyword'] . '%');
                }
    
                // Lọc theo vai trò cụ thể
                $query->where('role_id', 5);
    
                // ✅ Thêm điều kiện lọc theo trạng thái hoạt động
                if (isset($condition['is_locked'])) {
                    $query->where('users.is_locked', $condition['is_locked']);
                }
            });
    
        if (!empty($relations)) {
            foreach ($relations as $relation) {
                $query->withCount($relation);
            }
        }
    
        if (!empty($condition['publish']) && $condition['publish'] != 0) {
            $query->where('publish', '=', $condition['publish']);
        }
    
        if (!empty($join)) {
            foreach ($join as $val) {
                $query->join($val[0], $val[1], $val[2], $val[3]);
            }
        }
    
        if (!empty($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }
    
        return $query->paginate($perPage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }
    
    public function update($user, $data)
    {
        return $user->update($data);
    }

    public function destroy($user)
    {
        if (!$user instanceof Model) {
            $user = $this->model->find($user); // Nếu truyền ID, tìm Model
        }

        if (!$user) {
            return false;
        }

        return $user->delete();
    }
}
