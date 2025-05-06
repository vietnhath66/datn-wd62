<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\RoleRepositoryInterface as RoleRepository;
use App\Services\Interfaces\RoleServiceInterface as RoleService;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Requests\DeleteProductCatalogueRequest;
use App\Http\Requests\StoreRoleRequest;

class RoleController extends Controller
{
    protected $RoleRepository;
    protected $RoleService;

    public function __construct(
        RoleRepository $RoleRepository,
        RoleService $RoleService,
    ) {
        $this->RoleRepository = $RoleRepository;
        $this->RoleService = $RoleService;
    }

    public function index(Request $request)
    {
        // $this->authorize('modules', 'admin.roles.index');
        $roles = $this->RoleService->paginate($request);
        // dd($roles);
        // $roles = $this->RoleRepository->getAll();
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
                'title' => 'Quản lý vai trò',
                'table' => 'Danh sách vai trò'
            ],
            'create' => [
                'title' => 'Thêm mới vai trò'
            ],
            'edit' => [
                'title' => 'Cập nhật vai trò'
            ],
            'delete' => [
                'title' => 'Xóa vai trò'
            ],
        ];
        // dd($roles->toArray());
        $template = 'admin.roles.index';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'roles'
        ));
    }

    public function create()
    {
        // $this->authorize('modules', 'admin.roles.create');
        $config = $this->configData();

        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý vai trò',
                'table' => 'Danh sách vai trò'
            ],
            'create' => [
                'title' => 'Thêm mới vai trò'
            ],
            'edit' => [
                'title' => 'Cập nhật vai trò'
            ],
            'delete' => [
                'title' => 'Xóa vai trò'
            ],
        ];

        $config['method'] = 'create';
        $template = 'admin.roles.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
        ));
    }

    public function store(StoreRoleRequest $request)
    {
        // dd($request);

        if ($this->RoleService->create($request)) {
            return redirect()->route('admin.roles.index')->with('success', 'Thêm mới vai trò thành công');
        }
        return redirect()->route('admin.roles.index')->with('error', 'Thêm mới vai trò không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'admin.roles.update');
        $role = $this->RoleRepository->getRoleById($id);
        // dd($role);
        $config = $this->configData();
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý vai trò',
                'table' => 'Danh sách vai trò'
            ],
            'create' => [
                'title' => 'Thêm mới vai trò'
            ],
            'edit' => [
                'title' => 'Cập nhật vai trò'
            ],
            'delete' => [
                'title' => 'Xóa vai trò'
            ],
        ];
        $config['method'] = 'edit';
        $template = 'admin.roles.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'role',
        ));
    }

    public function update($id, UpdateRoleRequest $request)
    {
        // dd($request);
        if ($this->RoleService->update($id, $request)) {
            return redirect()->route('admin.roles.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.roles.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'admin.roles.destroy');
        $config['seo'] = __('messages.productCatalogue');
        $productCatalogue = $this->RoleRepository->getProductCatalogueById($id);
        $template = 'admin.product.catalogue.delete';
        return view('admin.dashboard.layout', compact(
            'template',
            'productCatalogue',
            'config',
        ));
    }

    public function destroy(DeleteProductCatalogueRequest $request, $id)
    {
        if ($this->RoleService->destroy($id)) {
            return redirect()->route('admin.roles.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('admin.roles.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
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
