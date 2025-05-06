<?php

namespace App\Services;

use App\Repositories\Interfaces\ReviewRepositoryInterface as ReviewRepository;
use App\Services\Interfaces\ReviewServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * Class ReviewService
 * @package App\Services
 */
class ReviewService implements ReviewServiceInterface
{
    protected $ReviewRepository;

    public function __construct(ReviewRepository $ReviewRepository)
    {
        $this->ReviewRepository = $ReviewRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['status'] = $request->input('status');
        $perPage = $request->integer('per_page');

        $reviews = $this->ReviewRepository->pagination(
            ['*'],
            $condition,
            $perPage,
            ['path' => 'admin/review/index'],
            ['created_at', 'DESC'],
            [],
            ['user', 'product']
        );

        return $reviews;
    }

    public function destroy($review)
    {
        DB::beginTransaction();
        try {
            $this->ReviewRepository->destroy($review);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Lỗi xóa đánh giá: " . $e->getMessage());
            return false;
        }
    }
}
