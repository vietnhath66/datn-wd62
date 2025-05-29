<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\District;
use App\Models\Order;
use App\Models\Province;
use App\Models\Ward;
use Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function viewAccount()
    {
        $coupons = Coupon::all();
        $provinces = Province::all();
        $districts = District::all();
        $wards = Ward::all();
        $userId = Auth::id();

        // Tính tổng số tiền đã chi tiêu cho các đơn hàng thành công
        $totalSpent = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->sum('total');

        // Đếm số đơn hàng thành công
        $successfulOrdersCount = Order::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        // Đếm số đơn hàng đã hủy
        $cancelledOrdersCount = Order::where('user_id', $userId)
            ->where('status', 'cancelled')
            ->count();

        // Lấy các dữ liệu khác như cũ
        $coupons = Coupon::all();
        $provinces = Province::all();
        $districts = District::all();
        $wards = Ward::all();
        return view('client.master-account', compact(
            'coupons',
            'provinces',
            'districts',
            'wards',
            'totalSpent',
            'successfulOrdersCount',
            'cancelledOrdersCount'
        ));
    }


    public function accountMyOrder()
    {
        $userId = Auth::id();

        $orders = Order::where('user_id', $userId)
            ->with([
                'items' => function ($query) {
                    $query->with([
                        'product' => function ($subQuery) { // Mối quan hệ product() trong OrderItem
                            $subQuery->withTrashed();
                        },
                        'productVariant' => function ($subQuery) { // Mối quan hệ productVariant() trong OrderItem
                            $subQuery->withTrashed()
                                ->with([
                                    'product' => function ($prodQuery) { // Mối quan hệ product() trong ProductVariant
                                $prodQuery->withTrashed();
                            }
                                ]);
                        }
                    ]);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('client.account.my-order')->with([
            'orders' => $orders
        ]);
    }


    public function accountOrderDetail(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này.');
        }

        $order->load([
            'items' => function ($query) {
                $query->with([
                    'product' => function ($subQuery) { // Mối quan hệ product() trong OrderItem
                        $subQuery->withTrashed()->select(['id', 'name', 'image']); // Chọn cột cần thiết
                    },
                    'productVariant' => function ($subQuery) { // Mối quan hệ productVariant() trong OrderItem
                        $subQuery->withTrashed()
                            ->select(['id', 'product_id', 'name' /* các cột khác của variant nếu cần */])
                            ->with([
                                'product' => function ($prodQuery) { // Mối quan hệ product() trong ProductVariant
                            $prodQuery->withTrashed()->select(['id', 'image', 'name']); // Lấy ảnh và tên từ product cha của variant
                        }
                            ]);
                    }
                ]);
            },
            'ward:code,full_name', // Chọn cột để tối ưu
            'district:code,full_name',
            'province:code,full_name',
            'confirmer:id,name',
            'shipper:id,name'
        ]);

        return view('client.account.order-detail')->with([
            'order' => $order
        ]);
    }
}
