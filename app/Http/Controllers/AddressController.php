<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Attribute;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function create()
    {
        $provinces = Province::orderBy('full_name')->get();
        $districts = District::orderBy('full_name')->get();
        $wards = Ward::orderBy('full_name')->get();
        return view('client.account.address', compact('provinces', 'districts', 'wards'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|min:5',
            'city' => 'required|string',
            'district' => 'required|string',
            'neighborhood' => 'required|string',
        ]);

        $isDefault = Address::where('user_id', Auth::id())->count() == 0 ? 1 : 0;

        Address::create([
            'user_id' => Auth::id(),
            'province' => $request->city,
            'district' => $request->district,
            'neighborhood' => $request->neighborhood,
            'address' => $request->address,
            'is_default' => $isDefault,
        ]);

        // Trả JSON rõ ràng hơn, luôn luôn trả response JSON cho frontend xử lý
        return response()->json([
            'status' => 'success',
            'message' => 'Địa chỉ đã được lưu thành công!'
        ], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
