<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Services\Interfaces\ProductServiceInterface as ProductService;
use App\Repositories\Interfaces\ProductRepositoryInterface as productReponsitory;
use App\Repositories\Interfaces\AttributeCatalogueReponsitoryInterface as AttributeCatalogueRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Classes\Nestedsetbie;
use App\Models\AttributeCatalogue;
use App\Models\AttributeCatalogueLanguage;
use App\Models\Brand;
use App\Models\Language;

class ProductController extends Controller
{
    protected $productService;
    protected $productReponsitory;
    protected $languageReponsitory;
    protected $nestedset;
    protected $attributeCatalogue;

    public function __construct(
        ProductService $productService,
        ProductReponsitory $productReponsitory,
        AttributeCatalogueRepository $attributeCatalogue,
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $this->initialize();
            return $next($request);
        });

        $this->productService = $productService;
        $this->productReponsitory = $productReponsitory;
        $this->attributeCatalogue = $attributeCatalogue;
        $this->initialize();

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
        // $this->authorize('modules', 'admin.product.index');
        $products = $this->productService->paginate($request);
        // dd($products);


        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Product'
        ];

        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý sản phẩm',
                'table' => 'Danh sách sản phẩm'
            ],
            'create' => [
                'title' => 'Thêm mới sản phẩm'
            ],
            'edit' => [
                'title' => 'Cập nhật sản phẩm'
            ],
            'delete' => [
                'title' => 'Xóa sản phẩm'
            ],
        ];
        $template = 'admin.products.product.index';
        $dropdown = $this->nestedset->Dropdown();
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'products'
        ));
    }

    public function create()
    {
        // $this->authorize('modules', 'admin.product.create');
        $attributeCatalogue = AttributeCatalogue::get();
        $brands = Brand::get();
        $config = $this->configData();
        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý sản phẩm',
                'table' => 'Danh sách sản phẩm'
            ],
            'create' => [
                'title' => 'Thêm mới sản phẩm'
            ],
            'edit' => [
                'title' => 'Cập nhật sản phẩm'
            ],
            'delete' => [
                'title' => 'Xóa sản phẩm'
            ],
        ];
        $config['method'] = 'create';
        $dropdown = $this->nestedset->Dropdown();
        $template = 'admin.products.product.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'dropdown',
            'attributeCatalogue',
            'config',
            'brands'
        ));
    }

    public function store(StoreProductRequest $request)
    {
        // dd($request);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $request->merge(['image' => $path]);
        }

        if ($this->productService->create($request)) {
            return redirect()->route('admin.product.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('admin.product.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'admin.product.update');
        // $attributeCatalogue = AttributeCatalogue::with('attribute_catalogue_language')->get();
        $attributeCatalogue = AttributeCatalogue::get();
        $brands = Brand::get();

        $product = $this->productReponsitory->getProductById($id);
        // dd($product);


        $config = $this->configData();
        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý sản phẩm',
                'table' => 'Danh sách sản phẩm'
            ],
            'create' => [
                'title' => 'Thêm mới sản phẩm'
            ],
            'edit' => [
                'title' => 'Cập nhật sản phẩm'
            ],
            'delete' => [
                'title' => 'Xóa sản phẩm'
            ],
        ];
        $config['method'] = 'edit';
        $dropdown = $this->nestedset->Dropdown();
        // $album = json_decode($product->album);
        $template = 'admin.products.product.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'attributeCatalogue',
            'product',
            'brands',
        ));
    }

    public function update($id, UpdateProductRequest $request)
    {
        if ($this->productService->update($id, $request)) {
            return redirect()->route('admin.product.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.product.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'admin.product.destroy');
        $config['seo'] = __('messages.product');
        $product = $this->productReponsitory->getProductById($id, $this->language);
        $template = 'admin.product.product.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'product',
            'config',
        ));
    }

    public function destroy($id)
    {
        if ($this->productService->destroy($id, $this->language)) {
            return redirect()->route('admin.product.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('admin.product.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function configData()
    {
        return [
            'js' => [
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'backend/library/variant.js',
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/nice-select/js/jquery.nice-select.min.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                'backend/plugins/nice-select/css/nice-select.css',
                'backend/css/plugins/switchery/switchery.css',
                'backend/css/bootstrap.min.css'
            ]

        ];
    }



}
