<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReviewRepository
 * @package App\Repositories
 */
class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    protected $model;

    public function __construct(Review $model)
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
        $query = $this->model->select($column)
    ->with(['user', 'product']) // Đảm bảo load quan hệ
    ->where(function ($query) use ($condition) {
        if (!empty($condition['keyword'])) {
            $keyword = $condition['keyword'];
    
            $query->where(function ($q) use ($keyword) {
                $q->where('comment', 'LIKE', '%' . $keyword . '%')
                  ->orWhereHas('user', function ($q2) use ($keyword) {
                      $q2->where('name', 'LIKE', '%' . $keyword . '%');
                  })
                  ->orWhereHas('product', function ($q3) use ($keyword) {
                      $q3->where('name', 'LIKE', '%' . $keyword . '%');
                  });
            });
        }
    
        if (isset($condition['status'])) {
            $query->where('status', $condition['status']);
        }
    
        // ✅ Bổ sung điều kiện lọc đánh giá gốc (không phải reply)
        if (array_key_exists('parent_id', $condition)) {
            if ($condition['parent_id'] === null) {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $condition['parent_id']);
            }
        }
    });

        if (!empty($relations)) {
            $query->with($relations);
        }

        if (!empty($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $query->paginate($perPage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }

    public function getReviewById(int $id = 0)
    {
        $review = $this->model->find($id);

        if (!$review) {
            throw new \Exception("Không tìm thấy đánh giá với ID: $id");
        }

        return $review;
    }

    public function destroy($model)
    {
        if (!$model instanceof Model) {
            $model = $this->model->find($model);
        }

        if (!$model) {
            return false;
        }

        return $model->delete();
    }
}
