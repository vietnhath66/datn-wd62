<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\CounponRepositoryInterface as CounponRepository;
use App\Services\Interfaces\CounponServiceInterface as CounponService;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Requests\DeleteProductCatalogueRequest;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\StoreCounponRequest;

class CounponController extends Controller
{
    protected $CounponRepository;
    protected $CounponService;

    public function __construct(
        CounponRepository $CounponRepository,
        CounponService $CounponService,
    ) {
        $this->CounponRepository = $CounponRepository;
        $this->CounponService = $CounponService;
    }

    public function index(Request $request)
    {
        // $this->authorize('modules', 'admin.counpons.index');
        $counpons = $this->CounponService->paginate($request);

        // $counpons = $this->CounponRepository->getAll();
        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Counpons',
        ];
        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý khuyến mãi',
                'table' => 'Danh sách khuyến mãi'
            ],
            'create' => [
                'title' => 'Thêm mới khuyến mãi'
            ],
            'edit' => [
                'title' => 'Cập nhật khuyến mãi'
            ],
            'delete' => [
                'title' => 'Xóa khuyến mãi'
            ],
        ];
        // dd($counpons->toArray());
        $template = 'admin.counpons.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'counpons'
        ));
    }

    public function create()
    {
        // $this->authorize('modules', 'admin.counpons.create');
        $config = $this->configData();

        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý khuyến mãi',
                'table' => 'Danh sách khuyến mãi'
            ],
            'create' => [
                'title' => 'Thêm mới khuyến mãi'
            ],
            'edit' => [
                'title' => 'Cập nhật khuyến mãi'
            ],
            'delete' => [
                'title' => 'Xóa khuyến mãi'
            ],
        ];

        $config['method'] = 'create';
        $template = 'admin.counpons.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreCounponRequest $request)
    {
        // dd($request);

        if ($this->CounponService->create($request)) {
            return redirect()->route('admin.counpon.index')->with('success', 'Thêm mới khuyến mãi thành công');
        }
        return redirect()->route('admin.counpon.index')->with('error', 'Thêm mới khuyến mãi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'admin.counpons.update');
        $brand = $this->CounponRepository->getBrandById($id);
        // dd($brand);
        $config = $this->configData();
        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý khuyến mãi',
                'table' => 'Danh sách khuyến mãi'
            ],
            'create' => [
                'title' => 'Thêm mới khuyến mãi'
            ],
            'edit' => [
                'title' => 'Cập nhật khuyến mãi'
            ],
            'delete' => [
                'title' => 'Xóa khuyến mãi'
            ],
        ];
        $config['method'] = 'edit';
        $template = 'admin.counpons.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'brand',
        ));
    }

    public function udpate($id, UpdateBrandRequest $request)
    {
        // dd($request);
        if ($this->CounponService->update($id, $request)) {
            return redirect()->route('admin.counpons.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.counpons.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'admin.counpons.destroy');
        $config['seo'] = __('messages.productCatalogue');
        $productCatalogue = $this->CounponRepository->getProductCatalogueById($id, $this->language);
        $template = 'admin.product.catalogue.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'productCatalogue',
            'config',
        ));
    }

    public function destroy(DeleteProductCatalogueRequest $request, $id)
    {
        if ($this->CounponService->destroy($id, $this->language)) {
            return redirect()->route('admin.counpons.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('admin.counpons.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
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
