<?php

namespace App\Http\Controllers\Shipper;

use DB;
use Log;
use Auth;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ShipperProfile;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ShipperController extends Controller
{
    public function listOrderShipper()
    {
        // Truy vấn các đơn hàng:
        $orders = Order::
            where('status', 'confirm')     // 2. Lọc theo status = 'confirm'
            ->with(['items', 'items.product']) // Tải kèm thông tin cần thiết cho view
            ->orderBy('delivered_at', 'desc') // 3. Sắp xếp (ví dụ: theo ngày giao hàng giảm dần)
            // Hoặc ->orderBy('updated_at', 'desc')
            ->paginate(15); // 4. Phân trang (ví dụ: 15 đơn/trang)

        return view('shipper.list-order')->with([
            'orders' => $orders
        ]);
    }


    public function accountShipper()
    {
        $user = Auth::user();
        $user->load('shipperProfile');
        return view('shipper.shipper-account')->with([
            'user' => $user
        ]);
    }


    public function updateAccount(Request $request)
    {
        $user = Auth::user(); // Lấy user đang đăng nhập

        // --- Validate dữ liệu từ AJAX request ---
        // Tên key phải khớp với tên bạn gửi lên từ formData trong JS (vd: editName)
        $validatedData = $request->validate([
            'editName' => 'required|string|min:2|max:255',
            // Kiểm tra email unique, nhưng bỏ qua email của chính user hiện tại
            'editEmail' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            // Kiểm tra phone unique (nếu cần), bỏ qua user hiện tại
            // Sử dụng regex bạn cung cấp trong HTML hoặc regex đơn giản hơn
            // 'editPhone'     => ['required', 'string', 'regex:/^[0-9]{10,12}$/', Rule::unique('users', 'phone')->ignore($user->id)],
            'editPhone' => ['required', 'string', 'min:10', 'max:15', Rule::unique('users', 'phone')->ignore($user->id)],
            'editDob' => 'required|date|before_or_equal:today', // Validate ngày sinh
            'editVehicleType' => 'nullable|string|max:50',
            'editLicensePlate' => 'nullable|string|max:20',
        ], [
            // Custom error messages (Tiếng Việt)
            'editName.required' => 'Vui lòng nhập họ và tên.',
            'editName.min' => 'Họ và tên phải có ít nhất 2 ký tự.',
            'editEmail.required' => 'Vui lòng nhập email.',
            'editEmail.email' => 'Email không đúng định dạng.',
            'editEmail.unique' => 'Email này đã được sử dụng.',
            'editPhone.required' => 'Vui lòng nhập số điện thoại.',
            'editPhone.unique' => 'Số điện thoại này đã được sử dụng.',
            'editPhone.min' => 'Số điện thoại phải có ít nhất 10 chữ số.',
            'editPhone.max' => 'Số điện thoại không quá 15 chữ số.',
            // 'editPhone.regex' => 'Số điện thoại chỉ chứa 10-12 chữ số.',
            'editDob.required' => 'Vui lòng chọn ngày sinh.',
            'editDob.date' => 'Ngày sinh không hợp lệ.',
            'editDob.before_or_equal' => 'Ngày sinh không được là ngày trong tương lai.',
            'editVehicleType.max' => 'Loại xe không quá 50 ký tự.',
            'editLicensePlate.max' => 'Biển số không quá 20 ký tự.',
        ]);

        DB::beginTransaction(); // Dùng transaction
        try {
            // Cập nhật bảng users (Không cập nhật date_of_birth)
            $user->name = $validatedData['editName'];
            $user->email = $validatedData['editEmail'];
            $user->phone = $validatedData['editPhone'];
            // Không cập nhật $user->date_of_birth ở đây
            $user->save();

            // Cập nhật hoặc Tạo mới ShipperProfile (Cập nhật date_of_birth ở đây)
            $profile = ShipperProfile::firstOrCreate(
                [
                    'user_id' => $user->id,
                ]
            );
            $profile->date_of_birth = $validatedData['editDob'];
            $profile->vehicle_type = $validatedData['editVehicleType'];
            $profile->license_plate = $validatedData['editLicensePlate'];
            $profile->save();

            DB::commit();

            Log::info("Shipper account updated successfully for user ID: " . $user->id);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin tài khoản thành công!',
                'user' => $user->fresh()->load('shipperProfile')
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác nếu có lỗi
            Log::error("Error updating shipper account for user ID: " . $user->id . " - " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi hệ thống, không thể cập nhật tài khoản.'], 500);
        }
    }


    public function deliveredShipper()
    {
        $shipperId = Auth::id();

        // 2. Truy vấn các đơn hàng đang giao (`status = 'shipping'`) được gán cho shipper này
        $orders = Order::where('shipper_id', $shipperId)
            ->where('status', 'shipping') // Chỉ lấy đơn đang giao
            // ->with(['user:id,name']) // Load tên khách nếu cần hiển thị trong danh sách này
            ->orderBy('accepted_at', 'asc') // Sắp xếp theo thời gian nhận đơn tăng dần (ví dụ)
            ->paginate(10); // Phân trang

        // 3. === PHẦN TÍNH TOÁN THỐNG KÊ ĐÃ ĐƯỢC BỎ ĐI ===

        // 4. Trả về View "Giao Hàng" chỉ với danh sách đơn hàng
        // *** Đảm bảo tên view 'shipper.delivery' là chính xác ***
        return view('shipper.shipper-order', [
            'orders' => $orders,
        ]);
    }


public function updateOrderStatus(Order $order, Request $request)
{
    $shipperId = Auth::id();

    // 1. Kiểm tra quyền
    if ($order->shipper_id !== $shipperId) {
        return response()->json(['success' => false, 'message' => 'Bạn không được phép cập nhật đơn hàng này.'], 403);
    }

    // 2. Validate
    $allowedStatuses = ['completed', 'cancelled', 'refunded', 'failed', 'delivered', 'confirm'];

    $validatedData = $request->validate([
        'status' => ['required', Rule::in($allowedStatuses)],
        'note' => 'nullable|string|max:1000',
        // Không validate shipper_photo vì sẽ xử lý riêng bên dưới (base64 hoặc file)
    ], [
        'status.required' => 'Vui lòng chọn trạng thái mới.',
        'status.in' => 'Trạng thái cập nhật không hợp lệ.',
        'note.string' => 'Ghi chú phải là dạng văn bản.',
        'note.max' => 'Ghi chú không quá 1000 ký tự.',
    ]);

    $newStatus = $validatedData['status'];
    $oldStatus = $order->status;

    // 3. Không cho cập nhật nếu đã kết thúc
    if (in_array($oldStatus, ['completed', 'delivered', 'confirm', 'cancelled', 'returned', 'failed']) && $newStatus !== $oldStatus) {
        return response()->json(['success' => false, 'message' => 'Không thể thay đổi trạng thái của đơn hàng đã kết thúc hoặc đã hủy.'], 400);
    }

    DB::beginTransaction();
    try {
        // 4. Cập nhật trạng thái và ghi chú
        $order->status = $newStatus;
        $order->note = $validatedData['note'] ?? null;

       // 5. Xử lý ảnh: upload file hoặc base64
if ($request->hasFile('shipper_photo')) {
    $photo = $request->file('shipper_photo');
    $filename = 'shipper_photo_' . $order->id . '_' . time() . '.' . $photo->getClientOriginalExtension();

    // Lưu vào storage/app/public/shipper_photos
    $photo->storeAs('public/shipper_photos', $filename);

    // Lưu đường dẫn public (truy cập được từ trình duyệt)
    $order->shipper_photo = 'shipper_photos/' . $filename; 

} elseif ($request->filled('photo')) {
    $photoData = $request->input('photo');

    if (preg_match('/^data:image\/(\w+);base64,/', $photoData, $matches)) {
        $extension = strtolower($matches[1]);
        $allowedExt = ['jpeg', 'jpg', 'png'];

        if (!in_array($extension, $allowedExt)) {
            return response()->json(['success' => false, 'message' => 'Định dạng ảnh không hợp lệ.'], 422);
        }

        $base64Str = base64_decode(substr($photoData, strpos($photoData, ',') + 1));

        if ($base64Str === false) {
            return response()->json(['success' => false, 'message' => 'Dữ liệu ảnh không hợp lệ.'], 422);
        }

        $filename = 'shipper_photo_' . $order->id . '_' . time() . '.' . $extension;

        // Lưu vào storage/app/public/shipper_photos
        Storage::disk('public')->put("shipper_photos/$filename", $base64Str);

        // Lưu đường dẫn public
        $order->shipper_photo = 'shipper_photos/' . $filename;

    } else {
        return response()->json(['success' => false, 'message' => 'Dữ liệu ảnh không hợp lệ.'], 422);
    }
}


        // 6. Cập nhật timestamp nếu cần
        switch ($newStatus) {
            case 'completed':
                $order->delivered_at = now();
                if (strtolower($order->payment_status) === 'cod' || strtolower($order->payment_status) === 'pending') {
                    $order->payment_status = 'paid';
                }
                break;
            case 'cancelled':
                $order->cancelled_at = now();
                break;
            case 'refunded':
                $order->refunded_at = now();
                break;
            case 'failed':
                $order->failed_at = now();
                break;
        }

        $order->save();

        Log::info("Shipper {$shipperId} cập nhật đơn hàng {$order->id} từ '{$oldStatus}' sang '{$newStatus}'. Ghi chú: " . ($validatedData['note'] ?? ''));

        // 7. Phục hồi tồn kho nếu đơn bị huỷ hoặc hoàn
        if (in_array($newStatus, ['cancelled', 'returned'])) {
            $order->load('items.productVariant');
            foreach ($order->items as $item) {
                if ($item->productVariant) {
                    $item->productVariant->increment('quantity', $item->quantity);
                    Log::info("Khôi phục tồn kho cho biến thể {$item->product_variant_id}: +{$item->quantity}");
                } else {
                    Log::warning("Không tìm thấy biến thể {$item->product_variant_id} để khôi phục tồn kho.");
                }
            }
        }

        DB::commit();

        // 8. Badge trạng thái mới
        $newStatusBadge = match (strtolower($order->status ?? '')) {
            'pending' => '<span class="badge bg-warning text-dark">Chưa hoàn tất</span>',
            'processing' => '<span class="badge bg-info text-dark">Đang xử lý</span>',
            'confirm' => '<span class="badge bg-success">Đã xác nhận</span>',
            'shipping' => '<span class="badge bg-primary">Đang vận chuyển</span>',
            'completed' => '<span class="badge bg-success">Đã hoàn thành</span>',
            'cancelled' => '<span class="badge bg-danger">Đã hủy</span>',
            'refunded' => '<span class="badge bg-danger">Đã hoàn lại</span>',
            'failed' => '<span class="badge bg-danger">Giao thất bại</span>',
            default => '<span class="badge bg-light text-dark">' . ucfirst($order->status ?? 'Không rõ') . '</span>',
        };

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái đơn hàng thành công!',
            'newStatus' => $newStatus,
            'newStatusBadge' => $newStatusBadge,
            'shipperPhoto' => $order->shipper_photo ?? null,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Lỗi khi cập nhật trạng thái đơn hàng {$order->id}: " . $e->getMessage());
        return response()->json(['success' => false, 'message' => 'Lỗi hệ thống khi cập nhật trạng thái.'], 500);
    }
}



    public function orderDetailShipper(Order $order)
    {
        // 2. Tải (Eager Load) các relationship cần thiết cho view
        // Giúp tránh N+1 query khi hiển thị thông tin items, products, variants
        $order->load([
            'items' => function ($query) {
                // Chỉ lấy các cột cần thiết của OrderDetail nếu muốn tối ưu
                // $query->select('id', 'order_id', 'product_id', 'product_variant_id', 'quantity', 'price');
            },
            'ward',
            'district',
            'province',
            'items.product:id,name,image',
            // Lấy thông tin biến thể
            'items.productVariant' => function ($query) {
                // Lấy các cột cần thiết của variant, và load kèm product của nó (nếu cần ảnh fallback)
                // Thêm các cột/accessor chứa tên màu/size nếu bạn cần hiển thị chúng
                $query->select(['id', 'product_id', 'quantity', 'price', 'name_variant_color', 'name_variant_size']) // Ví dụ tên cột màu/size
                    ->with('products:id,image'); // Load product từ variant chỉ lấy id, image
            },
            // Load thông tin khách hàng nếu cần hiển thị thêm (ngoài tên/email/sđt đã có trên Order)
            // 'user:id,name'
        ]);


        // 3. Trả về view chi tiết dành cho shipper
        // Đảm bảo đường dẫn view 'shipper.order.detail' là chính xác
        return view('shipper.order-detail', ['order' => $order]);
    }


    public function acceptOrder(Order $order)
    {
        $shipperId = Auth::id(); // Lấy ID shipper đang đăng nhập

        // Kiểm tra quyền (Middleware nên xử lý vai trò shipper rồi)

        // Kiểm tra trạng thái đơn hàng có phù hợp để nhận không?
        // Ví dụ: Chỉ cho nhận khi status là 'processing' và chưa có ai nhận (shipper_id is null)
        // *** Bạn cần định nghĩa trạng thái nào là hợp lệ để nhận đơn ***
        if (strtolower($order->status) !== 'confirm' || !is_null($order->shipper_id)) {
            Log::warning("Shipper {$shipperId} không thể nhận Order {$order->id}. Status: {$order->status}, Current Shipper: {$order->shipper_id}");
            // Quay lại trang danh sách đơn hàng với lỗi (Kiểm tra tên route)
            return redirect()->route('shipper.listOrderShipper')
                ->with('error', 'Đơn hàng này không thể nhận hoặc đã được shipper khác nhận.');
        }

        try {
            // Cập nhật đơn hàng
            $order->shipper_id = $shipperId;      // Gán shipper
            $order->status = 'shipping';        // Đổi trạng thái thành "Đang giao"
            $order->accepted_at = now();          // Ghi lại thời gian nhận đơn
            $order->save();

            Log::info("Shipper {$shipperId} accepted Order {$order->id}. Status changed to 'shipping'.");

            // Chuyển hướng đến trang "Giao Hàng" với thông báo thành công
            // *** KIỂM TRA LẠI TÊN ROUTE 'shipper.deliveredShipper' ***
            return redirect()->back()->with('success', "Đã nhận đơn hàng #{$order->barcode}.");

        } catch (\Exception $e) {
            Log::error("Lỗi acceptOrder cho Order {$order->id} bởi Shipper {$shipperId}: " . $e->getMessage());
            return redirect()->route('shipper.listOrderShipper')
                ->with('error', 'Đã xảy ra lỗi khi nhận đơn hàng. Vui lòng thử lại.');
        }
    }
}