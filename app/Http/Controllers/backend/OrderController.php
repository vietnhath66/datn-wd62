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
        // $this->authorize('modules', 'admin.product.index');
        $orders = $this->orderService->paginates($request);
        // dd($orders->toArray());

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
        $template = 'admin.orders.index';
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
        if (!$order) {
            return redirect()->route('admin.order.index')->with('error', 'Đơn hàng không tồn tại');
        }



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

        // Cập nhật thông tin đơn hàng
        $order->update($request->only([
            'status',
            'payment_status'
        ]));

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
