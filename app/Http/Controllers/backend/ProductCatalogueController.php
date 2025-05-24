<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\ProductCatalogueServiceInterface  as ProductCatalogueService;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface  as ProductCatalogueReponsitory;
use App\Http\Requests\StoreProductCatalogueRequest;
use App\Http\Requests\UpdateProductCatalogueRequest;
use App\Http\Requests\DeleteProductCatalogueRequest;
use App\Classes\Nestedsetbie;
use App\Models\Language;
use App\Models\OrderItem;

class ProductCatalogueController extends Controller
{

    protected $productCatalogueService;
    protected $productCatalogueReponsitory;
    protected $nestedset;
    protected $language;

    public function __construct(
        ProductCatalogueService $productCatalogueService,
        ProductCatalogueReponsitory $productCatalogueReponsitory
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale();
            $this->initialize();
            return $next($request);
        });


        $this->productCatalogueService = $productCatalogueService;
        $this->productCatalogueReponsitory = $productCatalogueReponsitory;
    }

    private function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'product_catalogues',
            'foreignkey' => 'product_catalogue_id',
        ]);
    }

    public function index(Request $request)
    {
        // $this->authorize('modules', 'admin.product_catalogue.index');
        $productCatalogues = $this->productCatalogueService->paginate($request);
        for ($i = 0; $i < count($productCatalogues); $i++) {
            $children = [];

                foreach ($productCatalogues as $key) {
                    if ($key->parent_id == $productCatalogues[$i]->id) {
                        array_push($children, $key);
                    }
                }
                $productCatalogues[$i]->children = $children;
            // if ($productCatalogues[$i]->parent_id == 0) {
                
            // }
        }

        $productCatalogues = $productCatalogues->filter(function ($item) {
            return !empty($item->parent_id == 0);
        });
        // dd($productCatalogues);

        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'ProductCatalogue',
        ];

        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý loại sản phẩm',
                'table' => 'Danh sách loại sản phẩm'
            ],
            'create' => [
                'title' => 'Thêm mới loại sản phẩm'
            ],
            'edit' => [
                'title' => 'Cập nhật loại sản phẩm'
            ],
            'delete' => [
                'title' => 'Xóa loại sản phẩm'
            ],
        ];
        // dd($config);
        $template = 'admin.products.catalogue.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'productCatalogues'
        ));
    }

    public function create()
    {
        // $this->authorize('modules', 'admin.product_catalogue.create');
        $config = $this->configData();
        $config['seo'] = $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý loại sản phẩm',
                'table' => 'Danh sách loại sản phẩm'
            ],
            'create' => [
                'title' => 'Thêm mới loại sản phẩm'
            ],
            'edit' => [
                'title' => 'Cập nhật loại sản phẩm'
            ],
            'delete' => [
                'title' => 'Xóa loại sản phẩm'
            ],
        ];
        $config['method'] = 'create';
        $dropdown  = $this->nestedset->Dropdown();
        // dd($dropdown);
        $template = 'admin.products.catalogue.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
        ));
    }

    public function store(StoreProductCatalogueRequest $request)
    {
        // dd($request);

        if ($this->productCatalogueService->create($request)) {
            return redirect()->route('admin.product_catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('admin.product_catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'admin.product_catalogue.update');
        $productCatalogue = $this->productCatalogueReponsitory->getProductCatalogueById($id);
        $config = $this->configData();
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý loại sản phẩm',
                'table' => 'Danh sách loại sản phẩm'
            ],
            'create' => [
                'title' => 'Thêm mới loại sản phẩm'
            ],
            'edit' => [
                'title' => 'Cập nhật loại sản phẩm'
            ],
            'delete' => [
                'title' => 'Xóa loại sản phẩm'
            ],
        ];
        $config['method'] = 'edit';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'admin.products.catalogue.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'productCatalogue',
        ));
    }

    public function update($id, UpdateProductCatalogueRequest $request)
    {
        

        if ($this->productCatalogueService->update($id, $request)) {
            return redirect()->route('admin.product_catalogue.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        
        return redirect()->route('admin.product_catalogue.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        // $this->authorize('modules', 'admin.product_catalogue.destroy');
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý loại sản phẩm',
                'table' => 'Danh sách loại sản phẩm'
            ],
            'create' => [
                'title' => 'Thêm mới loại sản phẩm'
            ],
            'edit' => [
                'title' => 'Cập nhật loại sản phẩm'
            ],
            'delete' => [
                'title' => 'Xóa loại sản phẩm'
            ],
        ];
        $productCatalogue = $this->productCatalogueReponsitory->getProductCatalogueById($id);
        $template = 'admin.products.catalogue.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'productCatalogue',
            'config',
        ));
    }

    public function destroy(DeleteProductCatalogueRequest $request, $id)
    {
        // dd($request);
        if ($this->productCatalogueService->destroy($id)) {
            return redirect()->route('admin.product_catalogue.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('admin.product_catalogue.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
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
