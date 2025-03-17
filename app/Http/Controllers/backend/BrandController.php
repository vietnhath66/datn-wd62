<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\BrandRepositoryInterface as BrandRepository;
use App\Services\Interfaces\BrandServiceInterface as BrandService;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Requests\DeleteProductCatalogueRequest;
use App\Http\Requests\StoreBrandRequest;

class BrandController extends Controller
{
    protected $BrandRepository;
    protected $BrandService;

    public function __construct(
        BrandRepository $BrandRepository,
        BrandService $BrandService,
    ) {
        $this->BrandRepository = $BrandRepository;
        $this->BrandService = $BrandService;
    }

    public function index(Request $request)
    {
        // $this->authorize('modules', 'admin.brands.index');
        $brands = $this->BrandService->paginate($request);

        // $brands = $this->BrandRepository->getAll();
        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Brands',
        ];
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý thương hiệu',
                'table' => 'Danh sách thương hiệu'
            ],
            'create' => [
                'title' => 'Thêm mới thương hiệu'
            ],
            'edit' => [
                'title' => 'Cập nhật thương hiệu'
            ],
            'delete' => [
                'title' => 'Xóa thương hiệu'
            ],
        ];
        // dd($brands->toArray());
        $template = 'admin.brands.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'brands'
        ));
    }

    public function create()
    {
        // $this->authorize('modules', 'admin.brands.create');
        $config = $this->configData();

        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý thương hiệu',
                'table' => 'Danh sách thương hiệu'
            ],
            'create' => [
                'title' => 'Thêm mới thương hiệu'
            ],
            'edit' => [
                'title' => 'Cập nhật thương hiệu'
            ],
            'delete' => [
                'title' => 'Xóa thương hiệu'
            ],
        ];

        $config['method'] = 'create';
        $template = 'admin.brands.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreBrandRequest $request)
    {
        // dd($request);

        if ($this->BrandService->create($request)) {
            return redirect()->route('admin.brands.index')->with('success', 'Thêm mới thương hiệu thành công');
        }
        return redirect()->route('admin.brands.index')->with('error', 'Thêm mới thương hiệu không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'admin.brands.update');
        $brand = $this->BrandRepository->getBrandById($id);
        // dd($brand);
        $config = $this->configData();
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý thương hiệu',
                'table' => 'Danh sách thương hiệu'
            ],
            'create' => [
                'title' => 'Thêm mới thương hiệu'
            ],
            'edit' => [
                'title' => 'Cập nhật thương hiệu'
            ],
            'delete' => [
                'title' => 'Xóa thương hiệu'
            ],
        ];
        $config['method'] = 'edit';
        $template = 'admin.brands.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'brand',
        ));
    }

    public function update($id, UpdateBrandRequest $request)
    {
        // Kiểm tra ID có hợp lệ không
        $brand = $this->BrandRepository->getBrandById($id);
        
        if (!$brand) {
            return redirect()->route('admin.brands.index')->with('error', 'Thương hiệu không tồn tại.');
        }
    
        // Thử cập nhật thương hiệu
        if ($this->BrandService->update($id, $request)) {
            return redirect()->route('admin.brands.index')->with('success', 'Cập nhật bản ghi thành công');
        }
    
        return redirect()->route('admin.brands.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }
    

    public function delete($id)
    {
        $this->authorize('modules', 'admin.brands.destroy');
        $config['seo'] = __('messages.productCatalogue');
        $productCatalogue = $this->BrandRepository->getProductCatalogueById($id);
        $template = 'admin.product.catalogue.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'productCatalogue',
            'config',
        ));
    }

    public function destroy(DeleteProductCatalogueRequest $request, $id)
    {
        if ($this->BrandService->destroy($id)) {
            return redirect()->route('admin.brands.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('admin.brands.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
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
