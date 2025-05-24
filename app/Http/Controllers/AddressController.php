<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\User; // Import User model
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB facade for transactions

class AddressController extends Controller
{
    /**
     * Constructor to apply middleware.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Đảm bảo người dùng đã đăng nhập
    }

    /**
     * Display a listing of the resource and the form to create a new one.
     * (Kết hợp index và create)
     *
     * @return \Illuminate\View\View
     */
    public function index() // Hoặc bạn có thể gọi là create() nếu đó là mục đích chính
    {
        $user = Auth::user();
        $provinces = Province::orderBy('full_name')->get();
        $userAddresses = Address::where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();

        return view('client.account.address', compact('provinces', 'userAddresses', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'address' => 'required|string|min:5|max:255',
            'city' => 'required|string|max:100',        // Tên Tỉnh/Thành phố
            'district' => 'required|string|max:100',    // Tên Quận/Huyện
            'neighborhood' => 'required|string|max:100', // Tên Phường/Xã
            // Thêm các validation khác nếu cần (ví dụ: name, phone_number cho địa chỉ)
        ]);

        $user = Auth::user();

        // Kiểm tra xem có phải địa chỉ đầu tiên không để đặt làm mặc định
        $isDefault = Address::where('user_id', $user->id)->count() == 0;

        // Nếu địa chỉ mới được đặt làm mặc định, bỏ mặc định các địa chỉ cũ
        if ($request->has('is_default') && $request->boolean('is_default') && !$isDefault) {
             Address::where('user_id', $user->id)->update(['is_default' => false]);
             $isDefault = true;
        } else if ($isDefault) {
            // Đã tự động là default nếu là cái đầu tiên
        } else {
            $isDefault = $request->has('is_default') ? $request->boolean('is_default') : false;
        }


        $newAddress = Address::create([
            'user_id' => $user->id,
            'province' => $validatedData['city'],
            'district' => $validatedData['district'],
            'neighborhood' => $validatedData['neighborhood'],
            'address' => $validatedData['address'],
            'is_default' => $isDefault,
            // Thêm các trường khác nếu có (name, phone_number)
            // 'name' => $request->input('address_name'),
            // 'phone_number' => $request->input('phone_number'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Địa chỉ đã được lưu thành công!',
            'address' => [
                'id' => $newAddress->id,
                'user_name' => $user->name, // Tên người dùng
                'address_label' => $newAddress->name, // Nếu có tên/nhãn cho địa chỉ
                'province' => $newAddress->province,
                'district' => $newAddress->district,
                'ward' => $newAddress->neighborhood,
                'address_detail' => $newAddress->address,
                'phone_number' => $newAddress->phone_number, // Nếu có SĐT
                'is_default' => $newAddress->is_default,
            ]
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Address $address)
    {
        // Policy check: Đảm bảo người dùng chỉ sửa địa chỉ của chính họ
        if (Auth::id() !== $address->user_id) {
            if (request()->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Bạn không có quyền sửa địa chỉ này.'], 403);
            }
            abort(403, 'Bạn không có quyền sửa địa chỉ này.');
        }

        $provinces = Province::orderBy('full_name')->get();
        // Lấy districts của province đã chọn để pre-fill
        $selectedProvince = Province::where('full_name', $address->province)->first(); // Giả sử lưu full_name
        $districtsOfSelectedProvince = [];
        if($selectedProvince) {
            $districtsOfSelectedProvince = District::where('province_code', $selectedProvince->code)
                                                ->orderBy('full_name')->get();
        }

        // Lấy wards của district đã chọn để pre-fill
        $selectedDistrict = District::where('full_name', $address->district)
                                    ->where('province_code', $selectedProvince ? $selectedProvince->code : null)
                                    ->first();
        $wardsOfSelectedDistrict = [];
        if($selectedDistrict) {
            $wardsOfSelectedDistrict = Ward::where('district_code', $selectedDistrict->code)
                                          ->orderBy('full_name')->get();
        }


        if (request()->ajax()) {
            return response()->json([
                'address' => $address,
                'provinces' => $provinces, // Gửi kèm nếu JS cần load lại
                'districts_for_selected_province' => $districtsOfSelectedProvince,
                'wards_for_selected_district' => $wardsOfSelectedDistrict,
            ]);
        }

        // Nếu không phải AJAX, trả về view (ít dùng nếu làm SPA-like)
        // return view('client.account.address_edit_form_partial', compact('address', 'provinces', 'districtsOfSelectedProvince', 'wardsOfSelectedDistrict'));
        // Thông thường, bạn sẽ dùng JS để điền dữ liệu vào form có sẵn trên trang index/create.
        // Hoặc nếu bạn có trang edit riêng:
        // return view('client.account.address_edit', compact('address', 'provinces', 'districtsOfSelectedProvince', 'wardsOfSelectedDistrict'));
        // Vì đã có trang index hiển thị form và list, edit có thể là lấy data qua AJAX và JS tự fill
        // Ở đây tôi trả về JSON để JS xử lý fill form.
         return response()->json([
                'status' => 'success',
                'data' => [
                    'address' => $address->toArray(), // Chuyển Address model thành array
                    'selected_province_code' => $selectedProvince ? $selectedProvince->code : null,
                    'selected_district_code' => $selectedDistrict ? $selectedDistrict->code : null,
                    // ward code không cần vì ward là cấp cuối
                ]
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Address $address)
    {
        if (Auth::id() !== $address->user_id) {
            return response()->json(['status' => 'error', 'message' => 'Bạn không có quyền cập nhật địa chỉ này.'], 403);
        }

        $validatedData = $request->validate([
            'address' => 'required|string|min:5|max:255',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'neighborhood' => 'required|string|max:100',
            // 'address_name' => 'nullable|string|max:100',
            // 'phone_number' => 'nullable|string|max:15',
            'is_default' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $address, $validatedData) {
            $user = Auth::user();
            $isDefault = $request->has('is_default') ? $request->boolean('is_default') : $address->is_default;

            if ($isDefault && !$address->is_default) { // Nếu đang đặt làm mặc định và nó chưa phải mặc định
                Address::where('user_id', $user->id)
                    ->where('id', '!=', $address->id)
                    ->update(['is_default' => false]);
            } elseif (!$isDefault && Address::where('user_id', $user->id)->where('is_default', true)->count() === 1 && $address->is_default) {
                // Không cho bỏ default nếu đây là địa chỉ default duy nhất và đang cố bỏ nó
                // Hoặc bạn có thể chọn một địa chỉ khác làm default ngẫu nhiên
                // For simplicity, we'll allow unsetting it. User can set another one later.
                // If you want to prevent this, throw validation error or handle differently.
            }


            $address->update([
                'province' => $validatedData['city'],
                'district' => $validatedData['district'],
                'neighborhood' => $validatedData['neighborhood'],
                'address' => $validatedData['address'],
                'is_default' => $isDefault,
                // 'name' => $validatedData['address_name'] ?? $address->name,
                // 'phone_number' => $validatedData['phone_number'] ?? $address->phone_number,
            ]);
        });


        return response()->json([
            'status' => 'success',
            'message' => 'Địa chỉ đã được cập nhật thành công!',
            'address' => $address->fresh()->toArray() // Lấy dữ liệu mới nhất và chuyển thành array
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Address $address)
    {
        if (Auth::id() !== $address->user_id) {
            return response()->json(['status' => 'error', 'message' => 'Bạn không có quyền xóa địa chỉ này.'], 403);
        }

        DB::transaction(function () use ($address) {
            $wasDefault = $address->is_default;
            $userId = $address->user_id;
            $address->delete();

            // Nếu địa chỉ bị xóa là mặc định, và còn các địa chỉ khác, đặt địa chỉ mới nhất làm mặc định
            if ($wasDefault) {
                $remainingAddresses = Address::where('user_id', $userId)->orderByDesc('created_at')->get();
                if ($remainingAddresses->isNotEmpty() && !$remainingAddresses->contains('is_default', true)) {
                    $newDefault = $remainingAddresses->first();
                    $newDefault->is_default = true;
                    $newDefault->save();
                }
            }
        });

        return response()->json(['status' => 'success', 'message' => 'Địa chỉ đã được xóa thành công.']);
    }

    /**
     * Set the specified address as default.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\JsonResponse
     */
    public function setDefault(Request $request, Address $address)
    {
        if (Auth::id() !== $address->user_id) {
            return response()->json(['status' => 'error', 'message' => 'Bạn không có quyền thực hiện thao tác này.'], 403);
        }

        DB::transaction(function () use ($address) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
            $address->is_default = true;
            $address->save();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Địa chỉ đã được đặt làm mặc định.',
            'address_id' => $address->id // Trả về ID để JS cập nhật UI
        ]);
    }

    /**
     * Get districts by province code.
     *
     * @param  string $provinceCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistrictsByProvinceCode(Request $request, $provinceCode)
    {
        $province = Province::where('code', $provinceCode)->first();
        if (!$province) {
            return response()->json(['message' => 'Tỉnh/Thành phố không hợp lệ.'], 404);
        }

        $districts = District::where('province_code', $province->code) // Hoặc province_id = $province->id
            ->orderBy('full_name')
            ->get(['code', 'full_name']); // Chỉ lấy code và full_name

        if ($districts->isEmpty()) {
            // Trả về mảng rỗng thay vì message để JS dễ xử lý hơn
            return response()->json([]);
        }
        return response()->json($districts);
    }

    /**
     * Get wards by district code.
     *
     * @param  string $districtCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWardsByDistrictCode(Request $request, $districtCode)
    {
        $district = District::where('code', $districtCode)->first();
        if (!$district) {
            return response()->json(['message' => 'Quận/Huyện không hợp lệ.'], 404);
        }

        $wards = Ward::where('district_code', $district->code) // Hoặc district_id = $district->id
            ->orderBy('full_name')
            ->get(['code', 'full_name']); // Chỉ lấy code và full_name

        if ($wards->isEmpty()) {
            return response()->json([]);
        }
        return response()->json($wards);
    }
}