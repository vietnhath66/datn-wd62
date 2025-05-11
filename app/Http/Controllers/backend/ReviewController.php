<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ReviewRepositoryInterface as ReviewRepository;
use App\Services\Interfaces\ReviewServiceInterface as ReviewService;
use App\Http\Requests\DeleteReviewRequest;

class ReviewController extends Controller
{
    protected $ReviewRepository;
    protected $ReviewService;

    public function __construct(
        ReviewRepository $ReviewRepository,
        ReviewService $ReviewService,
    ) {
        $this->ReviewRepository = $ReviewRepository;
        $this->ReviewService = $ReviewService;
    }

    public function index(Request $request)
    {
        $reviews = $this->ReviewService->paginate($request);

        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Reviews',
        ];
        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý đánh giá',
                'table' => 'Danh sách đánh giá'
            ],
            'delete' => [
                'title' => 'Xóa đánh giá'
            ],
        ];

        $template = 'admin.reviews.index';
        return view('admin.dashboard.layout', compact(
            'template', 
            'config',
            'reviews'
        ));
    }

    public function delete($id)
    {
        $review = $this->ReviewRepository->getReviewById($id);
        $config['seo'] = ['delete' => ['title' => 'Xóa đánh giá']];
        $template = 'admin.review.delete';

        return view('admin.dashboard.layout', compact('template', 'config', 'review'));
    }

    public function destroy(DeleteReviewRequest $request, $id)
    {
        if ($this->ReviewService->destroy($id)) {
            return redirect()->route('admin.review.index')->with('success', 'Xóa đánh giá thành công');
        }
        return redirect()->route('admin.review.index')->with('error', 'Xóa đánh giá không thành công. Hãy thử lại');
    }

    private function configData()
    {
        return [
            'js' => [
                'admin/plugins/ckeditor/ckeditor.js',
                'admin/plugins/ckfinder_2/ckfinder.js',
                'admin/library/finder.js',
                'admin/library/seo.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]
        ];
    }
}
