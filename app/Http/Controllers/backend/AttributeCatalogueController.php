<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\AttributeCatalogueServiceInterface  as AttributeCatalogueService;
use App\Repositories\Interfaces\AttributeCatalogueReponsitoryInterface  as AttributeCatalogueReponsitory;
use App\Http\Requests\StoreAttributeCatalogueRequest;
use App\Http\Requests\UpdateAttributeCatalogueRequest;
use App\Http\Requests\DeleteAttributeCatalogueRequest;
use App\Classes\Nestedsetbie;
use Auth;
use App\Models\Language;
use Attribute;
use Illuminate\Support\Facades\App;
class AttributeCatalogueController extends Controller
{

    protected $attributeCatalogueService;
    protected $attributeCatalogueReponsitory;
    protected $nestedset;
    protected $language;

    public function __construct(
        AttributeCatalogueService $attributeCatalogueService,
        AttributeCatalogueReponsitory $attributeCatalogueReponsitory
    ){
        $this->middleware(function($request, $next){
            $locale = app()->getLocale();
            $this->initialize();
            return $next($request);
        });


        $this->attributeCatalogueService = $attributeCatalogueService;
        $this->attributeCatalogueReponsitory = $attributeCatalogueReponsitory;
    }

    private function initialize(){
        $this->nestedset = new Nestedsetbie([
            'table' => 'attribute_catalogues',
            'foreignkey' => 'attribute_catalogue_id',
        ]);
    } 
 
    public function index(Request $request){
        // $this->authorize('modules', 'admin.attribute_catalogue.index');
        $attributeCatalogues = $this->attributeCatalogueService->paginate($request);
        
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý loại thuộc tính',
                'table' => 'Danh sách loại thuộc tính'
            ],
            'create' => [
                'title' => 'Thêm mới loại thuộc tính'
            ],
            'edit' => [
                'title' => 'Cập nhật loại thuộc tính'
            ],
            'delete' => [
                'title' => 'Xóa loại thuộc tính'
            ],
        ];
        $template = 'admin.attributes.catalogue.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'attributeCatalogues'
        ));
    }

    public function create(){
        // $this->authorize('modules', 'admin.attribute_catalogue.create');
        $config = $this->configData();
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý loại thuộc tính',
                'table' => 'Danh sách loại thuộc tính'
            ],
            'create' => [
                'title' => 'Thêm mới loại thuộc tính'
            ],
            'edit' => [
                'title' => 'Cập nhật loại thuộc tính'
            ],
            'delete' => [
                'title' => 'Xóa loại thuộc tính'
            ],
        ];
        $config['method'] = 'create';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'admin.attributes.catalogue.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
        ));
    }

    public function store(StoreAttributeCatalogueRequest $request){
        if($this->attributeCatalogueService->create($request)){
            return redirect()->route('admin.attribute_catalogue.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('admin.attribute_catalogue.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        // dd(123);
        // $this->authorize('modules', 'admin.attribute_catalogue.update');
        $attributeCatalogue = $this->attributeCatalogueReponsitory->getAttributeCatalogueById($id);
        $config = $this->configData();
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý loại thuộc tính',
                'table' => 'Danh sách loại thuộc tính'
            ],
            'create' => [
                'title' => 'Thêm mới loại thuộc tính'
            ],
            'edit' => [
                'title' => 'Cập nhật loại thuộc tính'
            ],
            'delete' => [
                'title' => 'Xóa loại thuộc tính'
            ],
        ];
        $config['method'] = 'edit';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'admin.attributes.catalogue.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'attributeCatalogue',
        ));
    }

    public function update($id, UpdateAttributeCatalogueRequest $request){
        if($this->attributeCatalogueService->update($id, $request)){
            return redirect()->route('admin.attribute_catalogue.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.attribute_catalogue.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'admin.attribute_catalogue.destroy');
        $config['seo'] = __('messages.attributeCatalogue');
        $attributeCatalogue = $this->attributeCatalogueReponsitory->getAttributeCatalogueById($id, $this->language);
        $template = 'admin.attribute.catalogue.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'attributeCatalogue',
            'config',
        ));
    }

    public function destroy(DeleteAttributeCatalogueRequest $request, $id){
        if($this->attributeCatalogueService->destroy($id, $this->language)){
            return redirect()->route('admin.attribute_catalogue.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('admin.attribute_catalogue.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function configData(){
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
