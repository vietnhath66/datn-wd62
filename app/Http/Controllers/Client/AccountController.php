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
        return view('client.master-account', compact('coupons', 'provinces', 'districts', 'wards'));
    }


    public function accountMyOrder()
    {
        $userId = Auth::id();

        $orders = Order::where('user_id', $userId)
            ->with(['items', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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
            'items',
            'ward',
            'district',
            'province',
            'items.product:id,name,image',
            'items.productVariant' => function ($query) {
                $query->select(['id', 'product_id',])
                    ->with('products:id,image');
            },
            'confirmer:id,name',
            'shipper:id,name'
        ]);
        return view('client.account.order-detail')->with([
            'order' => $order
        ]);
    }
}
