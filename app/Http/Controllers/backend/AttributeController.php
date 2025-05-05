<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\AttributeServiceInterface  as AttributeService;
use App\Repositories\Interfaces\AttributeReponsitoryInterface  as AttributeReponsitory;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Requests\DeleteAttributeRequest;
use App\Classes\Nestedsetbie;
use App\Models\Language;

class AttributeController extends Controller
{
    protected $attributeService;
    protected $attributeReponsitory;
    protected $languageReponsitory;
    protected $nestedset;
    protected $language;

    public function __construct(
        AttributeService $attributeService,
        AttributeReponsitory $attributeReponsitory,
    ){
        $this->middleware(function($request, $next){
            $locale = app()->getLocale(); // vn en cn
            $this->initialize();
            return $next($request);
        });

        $this->attributeService = $attributeService;
        $this->attributeReponsitory = $attributeReponsitory;
        $this->initialize();  
    }

    private function initialize(){
        $this->nestedset = new Nestedsetbie([
            'table' => 'attribute_catalogues',
            'foreignkey' => 'attribute_catalogue_id',
        ]);
    } 

    public function index(Request $request){
        // $this->authorize('modules', 'admin.attribute.index');
        $attributes = $this->attributeService->paginate($request);
        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Attribute'
        ];
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý thuộc tính',
                'table' => 'Danh sách thuộc tính'
            ],
            'create' => [
                'title' => 'Thêm mới thuộc tính'
            ],
            'edit' => [
                'title' => 'Cập nhật thuộc tính'
            ],
            'delete' => [
                'title' => 'Xóa thuộc tính'
            ],
        ];
        $template = 'admin.attributes.attribute.index';
        $dropdown  = $this->nestedset->Dropdown();
        // dd($attributes);
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'attributes'
        ));
    }

    public function create(){
        // $this->authorize('modules', 'admin.attribute.create');
        $config = $this->configData();
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý thuộc tính',
                'table' => 'Danh sách thuộc tính'
            ],
            'create' => [
                'title' => 'Thêm mới thuộc tính'
            ],
            'edit' => [
                'title' => 'Cập nhật thuộc tính'
            ],
            'delete' => [
                'title' => 'Xóa thuộc tính'
            ],
        ];
        $config['method'] = 'create';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'admin.attributes.attribute.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
        ));
    }

    public function store(StoreAttributeRequest $request){
        if($this->attributeService->create($request)){
            return redirect()->route('admin.attribute.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('admin.attribute.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id){
        // $this->authorize('modules', 'admin.attribute.update');
        $attribute = $this->attributeReponsitory->getAttributeById($id);
        $config = $this->configData();
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý thuộc tính',
                'table' => 'Danh sách thuộc tính'
            ],
            'create' => [
                'title' => 'Thêm mới thuộc tính'
            ],
            'edit' => [
                'title' => 'Cập nhật thuộc tính'
            ],
            'delete' => [
                'title' => 'Xóa thuộc tính'
            ],
        ];
        $config['method'] = 'edit';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'admin.attributes.attribute.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'attribute',
        ));
    }

    public function update($id, UpdateAttributeRequest $request){
        if($this->attributeService->update($id, $request)){
            return redirect()->route('admin.attribute.index')->with('success','Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.attribute.index')->with('error','Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id){
        $this->authorize('modules', 'admin.attribute.destroy');
        $config['seo'] = __('messages.attribute');
        $attribute = $this->attributeReponsitory->getAttributeById($id, $this->language);
        $template = 'admin.attribute.attribute.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'attribute',
            'config',
        ));
    }

    public function destroy($id){
        // $attribute = $this->attributeReponsitory->getAttributeById($attribute);
        if($this->attributeService->destroy($id)){
            return redirect()->route('admin.attribute.index')->with('success','Xóa bản ghi thành công');
        }
        return redirect()->route('admin.attribute.index')->with('error','Xóa bản ghi không thành công. Hãy thử lại');
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
