<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Lấy giá trị tìm kiếm
        $title = $request->get('title');
        $position = $request->get('position');

        // Truy vấn danh sách banner có lọc
        $banners = Banner::select('id', 'title', 'description', 'image', 'link', 'position', 'is_active', 'created_at', 'updated_at')
            ->when($title, function ($query) use ($title) {
                $query->where('title', 'like', "%{$title}%");
            })
            ->when($position, function ($query) use ($position) {
                $query->where('position', $position);
            })
            ->orderBy('id', 'DESC')
            ->paginate(10);

        // View template được render trong layout admin
        $template = 'admin.banners.index';

        // Cấu hình cho view
        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Banner'
        ];

        // Cấu hình SEO
        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý banner',
                'table' => 'Danh sách banner'
            ],
            'create' => [
                'title' => 'Thêm banner'
            ],
            'edit' => [
                'title' => 'Cập nhật banner'
            ],
            'delete' => [
                'title' => 'Xóa banner'
            ],
        ];



        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'banners'
        ));
    }

    public function create()
    {
        // Cấu hình cho view tạo mới banner
        $template = 'admin.banners.create';

        // Dropdown vị trí banner (có thể lấy từ enum hoặc constant)


        $config = [
            'js' => [
                'admin/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Banner'
        ];
        $config['method'] = 'create';

        // Cấu hình SEO cho view tạo mới
        $config['seo'] = [
            'create' => [
                'title' => 'Thêm banner'
            ],
        ];

        // Trả về view tạo mới banner
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
        ));
    }
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'link' => 'nullable|url',
            'position' => 'required|in:home_top,slide',
            'is_active' => 'required|boolean',
        ]);

        // Tạo một đối tượng banner mới
        $banner = new Banner();
        $banner->title = $request->input('title');
        $banner->description = $request->input('description');
        $banner->link = $request->input('link');
        $banner->position = $request->input('position');
        $banner->is_active = $request->input('is_active');


        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Lấy tên file gốc
            $imageName = $image->getClientOriginalName();

            // Lưu ảnh vào thư mục 
            $image->move(public_path('client/images'), $imageName);

            //     Lưu ảnh vào thư mục 'public/banners' với tên gốc
            //     $imagePath = $image->storeAs('storage/bannner', $imageName);

            $banner->image = $imageName;
        }

        // Lưu banner vào cơ sở dữ liệu
        $banner->save();

        // Chuyển hướng về trang danh sách banner với thông báo thành công
        return redirect()->route('admin.banner.index')->with('success', 'Banner đã được thêm thành công!');
    }

    public function edit($id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return redirect()->route('admin.banner.index')->with('error', 'Banner không tồn tại.');
        }

        $config = [
            'method' => 'edit',
            'seo' => [
                'index' => [
                    'title' => 'Quản lý banner',
                    'table' => 'Danh sách banner'
                ],
                'create' => [
                    'title' => 'Thêm banner'
                ],
                'edit' => [
                    'title' => 'Cập nhật banner'
                ],
                'delete' => [
                    'title' => 'Xóa banner'
                ],
                'url' => route('admin.banner.update', $id),
            ],
            
        ];

        $template = 'admin.banners.update';

        return view('admin.dashboard.layout', compact('template', 'config', 'banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return redirect()->route('admin.banner.index')->with('error', 'Banner không tồn tại.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'position' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Cập nhật thông tin
        $banner->title = $request->title;
        $banner->position = $request->position;
        $banner->link = $request->link;
        $banner->description = $request->description;
        $banner->is_active = $request->has('is_active');

        // Nếu có ảnh mới
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($banner->image && file_exists(public_path('client/images/' . $banner->image))) {
                unlink(public_path('client/images/' . $banner->image));
            }

            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('client/images'), $imageName);
            $banner->image = $imageName;
        }
        $banner->update($request->only(['title', 'description', 'link', 'position', 'is_active']));

        return redirect()->route('admin.banner.index')->with('success', 'Cập nhật banner thành công.');
    }


    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // Xóa file trong public/banners nếu tồn tại
        $imagePath = public_path('client/images' . $banner->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $banner->delete();

        return redirect()->route('admin.banner.index')->with('success', 'Xóa banner thành công');
    }

    // public function show($id)
    // {
    //     // Lấy thông tin đơn hàng
    //     $order = Order::select([
    //         'orders.id',
    //         'orders.user_id',
    //         'users.name as customer_name',
    //         'orders.email',
    //         'orders.phone',
    //         'orders.total',
    //         'orders.status',
    //         'orders.payment_status',
    //         'orders.payment_method',
    //         'orders.ward_code',
    //         'orders.barcode',
    //         'orders.province_code',
    //         'orders.district_code',
    //         'orders.address',
    //         'orders.created_at',
    //         'orders.updated_at'
    //     ])
    //         ->leftJoin('users', 'users.id', '=', 'orders.user_id')
    //         ->where('orders.id', $id)
    //         ->first(); // Dùng first() để chỉ lấy một bản ghi duy nhất

    //     if (!$order) {
    //         return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không tồn tại.');
    //     }

    //     // Lấy các item trong đơn hàng
    //     $orderItems = OrderItem::select([
    //         'order_items.*',
    //         'products.name as product_name',
    //         'products.image as image',
    //         'product_variants.name as variant_name',
    //         'product_variants.sku',
    //         'product_variants.name_variant_size',
    //         'product_variants.name_variant_color',
    //         'product_variants.price as variant_price'
    //     ])
    //         ->join('products', 'products.id', '=', 'order_items.product_id')
    //         ->leftJoin('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id')
    //         ->where('order_items.order_id', $id)
    //         ->get();

    //     // $orderItems = $orderItems ?: collect(); 

    //     $config = $this->configData();
    //     $config['seo'] = [
    //         'index' => [
    //             'title' => 'Quản lý đơn hàng',
    //             'table' => 'Danh sách đơn hàng',
    //             'show' => 'Thông tin đơn hàng'
    //         ],
    //         'show' => [
    //             'title' => 'Thông tin đơn hàng'
    //         ],
    //         'edit' => [
    //             'title' => 'Cập nhật đơn hàng'
    //         ],
    //         'delete' => [
    //             'title' => 'Xóa đơn hàng'
    //         ],
    //     ];
    //     $config['method'] = 'edit';

    //     $dropdown = $this->nestedset->Dropdownss();

    //     $template = 'admin.orders.show';

    //     return view('admin.dashboard.layout', compact(
    //         'template',
    //         'config',
    //         'dropdown',
    //         'order',
    //         'orderItems'
    //     ));
    // }


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
            ],

        ];
    }

}
