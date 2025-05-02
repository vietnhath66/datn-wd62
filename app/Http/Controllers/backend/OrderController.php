<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\ProductServiceInterface as ProductService;
use App\Services\Interfaces\OrderServiceInterface as OrderService;
use App\Repositories\Interfaces\ProductRepositoryInterface as productReponsitory;
use App\Repositories\Interfaces\OrderRepositoryInterface as orderReponsitory;
use App\Repositories\Interfaces\AttributeCatalogueReponsitoryInterface as AttributeCatalogueRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Classes\Nestedsetbie;
use App\Models\AttributeCatalogue;
use App\Models\AttributeCatalogueLanguage;
use App\Models\Brand;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Language;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $productService;
    protected $orderService;
    protected $productReponsitory;
    protected $orderReponsitory;
    protected $languageReponsitory;
    protected $nestedset;
    protected $attributeCatalogue;

    public function __construct(
        ProductService $productService,
        OrderService $orderService,
        ProductReponsitory $productReponsitory,
        orderReponsitory $orderReponsitory,
        AttributeCatalogueRepository $attributeCatalogue,
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $this->initialize();
            return $next($request);
        });

        $this->productService = $productService;
        $this->orderService = $orderService;
        $this->productReponsitory = $productReponsitory;
        $this->orderReponsitory = $orderReponsitory;
        $this->attributeCatalogue = $attributeCatalogue;
        $this->initialize();

    }

    private function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'users',
            'foreignkey' => 'user_id',
        ]);
    }

    public function index(Request $request)
{
    // Lấy giá trị tìm kiếm từ request
    $order_id = $request->get('order_id'); // Lấy mã đơn hàng từ request

    // Lọc đơn hàng theo mã đơn nếu có
    $orders = Order::selectRaw("
        orders.id,
        MAX(orders.user_id) as user_id,
        MAX(users.name) as customer_name,
        MAX(orders.email) as email,
        MAX(orders.phone) as phone,
        MAX(orders.total) as total,
        MAX(orders.status) as status,
        MAX(orders.payment_status) as payment_status,
        MAX(orders.payment_method) as payment_method,
        MAX(orders.neighborhood) as neighborhood,
        MAX(orders.barcode) as barcode,
        MAX(orders.province) as province,
        MAX(orders.district) as district,
        MAX(orders.number_house) as number_house,
        MAX(orders.address) as address,
        MAX(orders.created_at) as created_at,
        MAX(orders.updated_at) as updated_at
    ")
    ->leftJoin('users', 'users.id', '=', 'orders.user_id')
    ->when($order_id, function ($query) use ($order_id) {
        return $query->where('orders.barcode', 'like', "%{$order_id}%"); // Tìm kiếm theo mã đơn hàng
    })
    ->groupBy('orders.id')
    ->orderBy('orders.id', 'DESC')
    ->paginate(5); // Giới hạn kết quả trả về (5 đơn hàng mỗi trang)

    // Tải quan hệ sau khi lấy dữ liệu (Order Items, Products và Product Variants)
    $orders->load(['orderItems.products.product_variants']);

    // Trả về view với các dữ liệu cần thiết
    $template = 'admin.orders.index';
    $config = [
        'js' => [
            'admin/js/plugins/switchery/switchery.js',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
        ],
        'css' => [
            'admin/css/plugins/switchery/switchery.css',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
        ],
        'model' => 'Order'
    ];

    $config['seo'] = [
        'index' => [
            'title' => 'Quản lý đơn hàng',
            'table' => 'Danh sách đơn hàng'
        ],
        'create' => [
            'title' => 'Thêm mới đơn hàng'
        ],
        'edit' => [
            'title' => 'Cập nhật đơn hàng'
        ],
        'delete' => [
            'title' => 'Xóa đơn hàng'
        ],
    ];

    $dropdowns = $this->nestedset->Dropdownss();

    return view('admin.dashboard.layout', compact(
        'template',
        'config',
        'dropdowns',
        'orders'
    ));
}

    public function edit($id)
    {
        // Lấy thông tin đơn hàng
        $order = $this->orderReponsitory->getOrderById($id);
        // dd($order->toArray());
        if (!$order) {
            return redirect()->route('admin.order.index')->with('error', 'Đơn hàng không tồn tại');
        }



        $config = $this->configData();
        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý đơn hàng',
                'table' => 'Danh sách đơn hàng'
            ],
            'create' => [
                'title' => 'Thêm mới đơn hàng'
            ],
            'edit' => [
                'title' => 'Cập nhật đơn hàng'
            ],
            'delete' => [
                'title' => 'Xóa đơn hàng'
            ],
        ];
        $config['method'] = 'edit';

        // Load danh sách tỉnh/thành để chỉnh sửa địa chỉ nếu cần
        $dropdown = $this->nestedset->Dropdownss();

        // View template dành riêng cho đơn hàng
        $template = 'admin.orders.store';
        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'order'
        ));
    }

    public function update($id, Request $request)
    {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->route('admin.order.index')->with('error', 'Đơn hàng không tồn tại');
        }
        // dd($request->all());
        // Xác thực dữ liệu
        $request->validate([
            'status' => 'required|string|in:pending,processing,shipping,confirm,completed,cancelled,refunded,failed',
            'payment_status' => 'required|string|in:pending,paid,failed,refunded',
        ]);
        // Kiểm tra và áp dụng điều kiện chuyển đổi trạng thái
        if ($order->status == 'pending' && !in_array($request->status, ['processing', 'cancelled' ,'pending'])) {
            return back()->with('error', 'Không thể chuyển trạng thái từ "Chờ xử lý" sang trạng thái này.');
        }

        if ($order->status == 'processing' && !in_array($request->status, ['shipping', 'cancelled', 'processing'])) {
            return back()->with('error', 'Không thể chuyển trạng thái từ "Đang xử lý" sang trạng thái này.');
        }

        if ($order->status == 'shipping' && !in_array($request->status, ['confirm', 'failed', 'shipping'])) {
            return back()->with('error', 'Không thể chuyển trạng thái từ "Đang giao hàng" sang trạng thái này.');
        }

        if ($order->status == 'completed' || $order->status == 'cancelled' || $order->status == 'refunded' || $order->status == 'failed') {
            return back()->with('error', 'Không thể thay đổi trạng thái của đơn hàng sau khi đã hoàn tất, hủy, hoàn tiền hoặc thất bại.');
        }

        // Kiểm tra điều kiện trạng thái thanh toán khi cập nhật
        if ($request->status == 'confirm' && $request->payment_status != 'paid') {
            return back()->with('error', 'Khi đơn hàng đã giao, trạng thái thanh toán phải là "Đã thanh toán".');
        }

        if ($request->status == 'shipping' && !in_array($request->payment_status, ['pending', 'paid'])) {
            return back()->with('error', 'Khi đơn hàng đang giao, trạng thái thanh toán phải là "Chờ thanh toán" hoặc "Đã thanh toán".');
        }

        if ($request->status == 'completed' && $request->payment_status != 'paid' && $request->payment_status != 'refunded') {
            return back()->with('error', 'Khi đơn hàng đã hoàn tất, trạng thái thanh toán phải là "Đã thanh toán" hoặc "Đã hoàn tiền".');
        }
        // Cập nhật thông tin đơn hàng
        $order->update($request->only(['payment_status', 'status']));

        // Cập nhật sản phẩm trong đơn hàng nếu cần
        // if ($request->has('order_items')) {
        //     foreach ($request->order_items as $item) {
        //         $orderItem = OrderItem::find($item['id']);
        //         if ($orderItem) {
        //             $orderItem->update([
        //                 'quantity' => $item['quantity'],
        //                 'price' => $item['price']
        //             ]);
        //         }
        //     }
        // }

        return redirect()->route('admin.order.index')->with('success', 'Cập nhật đơn hàng thành công');
    }


    public function show($id)
    {
        // Lấy thông tin đơn hàng
        $order = Order::select([
            'orders.id',
            'orders.user_id',
            'users.name as customer_name',
            'orders.email',
            'orders.phone',
            'orders.total',
            'orders.status',
            'orders.payment_status',
            'orders.payment_method',
            'orders.neighborhood',
            'orders.barcode',
            'orders.province',
            'orders.district',
            'orders.number_house',
            'orders.address',
            'orders.created_at',
            'orders.updated_at'
        ])
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->where('orders.id', $id)
            ->first(); // Dùng first() để chỉ lấy một bản ghi duy nhất

        if (!$order) {
            return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không tồn tại.');
        }

        // Lấy các item trong đơn hàng
        $orderItems = OrderItem::select([
            'order_items.*',
            'products.name as product_name',
            'products.image as image',
            'product_variants.name as variant_name',
            'product_variants.sku',
            'product_variants.name_variant_size',
            'product_variants.name_variant_color',
            'product_variants.price as variant_price'
        ])
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->where('order_items.order_id', $id)
            ->get();

        // $orderItems = $orderItems ?: collect(); 

        $config = $this->configData();
        $config['seo'] = [
            'index' => [
                'title' => 'Quản lý đơn hàng',
                'table' => 'Danh sách đơn hàng',
                'show' => 'Thông tin đơn hàng'
            ],
            'show' => [
                'title' => 'Thông tin đơn hàng'
            ],
            'edit' => [
                'title' => 'Cập nhật đơn hàng'
            ],
            'delete' => [
                'title' => 'Xóa đơn hàng'
            ],
        ];
        $config['method'] = 'edit';

        $dropdown = $this->nestedset->Dropdownss();

        $template = 'admin.orders.show';

        return view('admin.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'order',
            'orderItems'
        ));
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
            ],
            'model' => 'Order'

        ];
    }



}
