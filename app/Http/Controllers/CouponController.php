<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        // Lấy tất cả các phiếu giảm giá
        $coupons = Coupon::all();  // Hoặc thêm điều kiện nếu cần như $coupons = Coupon::where('user_id', Auth::id())->get();

        // Trả dữ liệu ra view
        return view('client.account.header', compact('coupons'));
    }
    public function accountPage()
{
    $coupons = Coupon::all(); // hoặc thêm logic lọc theo user hoặc thời gian

    return view('client.master-account', compact('coupons'));
}

}
