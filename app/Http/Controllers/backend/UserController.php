<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\ProvinceReponsitoryInterface as provinceReponsitory;
use App\Repositories\Interfaces\RoleRepositoryInterface as roleRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    const PATH_UPLOAD = 'users';

    protected $UserService;
    protected $provinceReponsitory;
    protected $roleRepository;
    

    public function __construct(UserService $UserService, provinceReponsitory $provinceReponsitory, roleRepository $roleRepository)
    {
        $this->UserService = $UserService;
        $this->provinceReponsitory = $provinceReponsitory;
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        // $this->authorize('modules', 'admin.users.index');
        $request->merge(['is_locked' => 0]); // chỉ lấy user đang hoạt động
        $users = $this->UserService->paginate($request);
        // dd($users);

        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]
        ];

        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý người dùng',
                'table' => 'Danh sách người dùng'
            ],
            'create' => [
                'title' => 'Thêm mới người dùng'
            ],
            'edit' => [
                'title' => 'Cập nhật người dùng'
            ],
            'delete' => [
                'title' => 'Xóa người dùng'
            ],
        ];

        $template = 'admin.users.index';

        return view('admin.dashboard.layout', compact('template', 'config', 'users'));
    }

    public function create()
    {
        $this->authorize('modules', 'admin.users.create');

        $provinces = $this->provinceReponsitory->all();
        // $user_catalogues = $this->userCatalogueReponsitory->all();
        // dd($user_catalogues);
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'admin/library/location.js'
            ]
        ];

        $config['seo'] = config('apps.user');
        $config['method'] = 'create';
        $template = 'admin.user.user.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'provinces',
            // 'user_catalogues'
        ));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->except('_token');

        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        if ($this->UserService->create($data)) {
            return redirect()->route('admin.users.index')->with('success', 'Thêm mới User thành công !');
        } else {
            return redirect()->route('admin.users.index')->with('error', 'Thêm mới User thất bại! Hãy thử lại');
        }
    }

    public function edit(User $user)
    {
        // $this->authorize('modules', 'admin.users.update');

        $provinces = $this->provinceReponsitory->all();
        // $user_catalogues = $this->userCatalogueReponsitory->all();
        // dd($provinces);
        // $config = [
        //     'css' => [
        //         'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
        //     ],
        //     'js' => [
        //         'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
        //         'admin/library/location.js'
        //     ]
        // ];

        // $config['seo'] = config('apps.user');
        $config = $this->config();
        $config['seo'] =  [
            'index' => [
                'title' => 'Quản lý người dùng',
                'table' => 'Danh sách người dùng'
            ],
            'create' => [
                'title' => 'Thêm mới người dùng'
            ],
            'edit' => [
                'title' => 'Cập nhật người dùng'
            ],
            'delete' => [
                'title' => 'Xóa người dùng'
            ],
        ];
        $config['method'] = 'edit';
        $template = 'admin.users.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'provinces',
            'user',
            // 'user_catalogues'
        ));
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        $data = $request->except('_token', 'send', '_method');
        $data['password'] = $user->password;
        // dd($data);


        if ($request->hasFile('image')) {
            $data['image'] = Storage::put(self::PATH_UPLOAD, $request->file('image'));
        }

        $currentImage = $user->image;

        if ($request->hasFile('image') && $currentImage && Storage::exists($currentImage)) {
            Storage::delete($currentImage);
        }

        
        if ($this->UserService->update($data, $user)) {
            return redirect()->route('admin.users.index')->with('success', 'Cập nhật User thành công !');
        } else {
            return redirect()->route('admin.users.index')->with('error', 'Cập nhật User thất bại! Hãy thử lại');
        }
    }

    public function delete(User $user)
    {
        $this->authorize('modules', 'admin.users.destroy');

        $template = 'admin.user.user.delete';
        $config['seo'] = config('apps.user');

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'user'
        ));
    }


    
    public function destroy(User $user)
    {
        try {
            $currentImage = $user->image;
    
            if ($currentImage && Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
    
            if ($this->UserService->destroy($user)) {
                return redirect()->route('admin.users.index')->with('success', 'Xóa User thành công!');
            } else {
                return redirect()->route('admin.users.index')->with('error', 'Xóa User thất bại! Hãy thử lại.');
            }
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('admin.users.index')->with('error', 'Không thể xóa User vì có dữ liệu liên quan trong hệ thống.');
            }
    
            return redirect()->route('admin.users.index')->with('error', 'Đã xảy ra lỗi khi xóa User.');
        }
    }
    
    // Khoá tài khoản
public function lock(User $user)
{
    $user->is_locked = 1;
    $user->save();

    return redirect()->route('admin.users.locked')->with('success', 'Khóa tài khoản thành công!');
}

// Mở khóa tài khoản
public function unlock(User $user)
{
    $user->is_locked = 0;
    $user->save();

    return redirect()->route('admin.users.index')->with('success', 'Mở khóa tài khoản thành công!');
}

    private function config(){
        return [
            'js' => [
                'admin/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css'
            ]
        ];
    }
    public function locked(Request $request)
{
    $request->merge(['is_locked' => 1]); // chỉ lấy user đã bị khóa
    $users = $this->UserService->getLockedUsers($request); // giả sử bạn có phương thức này trong service

    $config = [
        'js' => [
            'admin/js/plugins/switchery/switchery.js',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
        ],
        'css' => [
            'admin/css/plugins/switchery/switchery.css',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
        ],
        'seo' => [
            'index' => [
                'title' => 'Danh sách tài khoản bị khóa',
                'table' => 'Danh sách tài khoản bị khóa'
            ],
        ]
    ];

    $template = 'admin.users.components.locked'; // bạn cần tạo view tương ứng nếu chưa có
    return view('admin.dashboard.layout', compact('template', 'config', 'users'));
}
}
