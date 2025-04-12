<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Log;
use Session;
use Validator;

class OrderController extends Controller
{
    public function viewOrder()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để đặt hàng.');
        }

        $orderId = Session::get('order_id');
        if (!$orderId) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        $order = Order::with('items.product')->find($orderId);
        $totalPrice = $order ? $order->total : 0;
        $user = Auth::user();

        if (!$order) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        return view('client.order.order')->with([
            'order' => $order,
            'totalPrice' => $totalPrice,
            'user' => $user
        ]);
    }


    public function checkout(Request $request)
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để đặt hàng.');
        }
        $userId = Auth::id();
        $user = Auth::user(); // Lấy thông tin user đang đăng nhập

        // 2. Validate input chứa ID sản phẩm được chọn từ giỏ hàng
        $validator = Validator::make($request->all(), [
            // Giả sử input tên là 'selected_products' chứa chuỗi ID cách nhau bởi dấu phẩy
            'selected_products' => [
                'required',
                // Custom validation rule để kiểm tra chuỗi ID hợp lệ
                function ($attribute, $value, $fail) {
                    $ids = explode(',', $value);
                    if (empty(array_filter($ids, 'is_numeric'))) {
                        $fail('Vui lòng chọn ít nhất một sản phẩm từ giỏ hàng.');
                    }
                    foreach ($ids as $id) {
                        if (!is_numeric(trim($id))) {
                            $fail('Danh sách sản phẩm chọn không hợp lệ.');
                            break;
                        }
                    }
                },
            ]
        ], [
            'selected_products.required' => 'Vui lòng chọn sản phẩm từ giỏ hàng để tiếp tục.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lấy danh sách ID các CartDetail được chọn
        $selectedCartItemIds = array_map('intval', explode(',', $request->input('selected_products')));

        // 3. Lấy các CartDetail được chọn thuộc về user này
        $selectedItems = CartDetail::whereIn('id', $selectedCartItemIds)
            ->whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('productVariant') // Eager load variant để lấy giá và kiểm tra tồn kho
            ->get();

        // Kiểm tra lại xem có thực sự lấy được item nào không (phòng trường hợp ID gửi lên không đúng)
        if ($selectedItems->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm được chọn trong giỏ hàng của bạn.');
        }

        DB::beginTransaction();
        try {

            // Nếu chưa có đơn hàng pending, tạo mới
            do {
                $barcode = mt_rand(100000000, 999999999);
            } while (Order::where('barcode', $barcode)->exists());

            $order = Order::create([
                'user_id' => $userId,
                // Lấy thông tin cơ bản từ user đăng nhập, không lấy từ request ở bước này
                'name' => $user->name, // Giả sử User model có 'name'
                'email' => $user->email, // Giả sử User model có 'email'
                'phone' => $user->phone, // Giả sử User model có 'phone'
                // Địa chỉ chi tiết sẽ được cập nhật ở bước 'completeOrder'
                'address' => null,
                'number_house' => null,
                'neighborhood' => null,
                'district' => null,
                'province' => null,
                'total' => 0, // Sẽ tính lại bên dưới
                'status' => 'pending',
                'payment_status' => 'pending',
                'coupon' => null, // Coupon sẽ xử lý sau nếu có
                'barcode' => $barcode,
            ]);
            Log::info("Created new pending order ID: {$order->id} for user ID: {$userId}");

            $totalPrice = 0;

            // 6. Thêm lại OrderDetail chỉ từ các sản phẩm đã được chọn trong giỏ hàng
            foreach ($selectedItems as $item) {
                // Kiểm tra tồn kho của biến thể trước khi thêm vào chi tiết đơn hàng
                if (!$item->productVariant || $item->productVariant->quantity < $item->quantity) {
                    DB::rollBack(); // Hoàn tác transaction
                    $productName = $item->productVariant->products->name ?? 'Sản phẩm'; // Lấy tên SP nếu có
                    $availableQty = $item->productVariant->quantity ?? 0;
                    return redirect()->route('cart.viewCart') // Quay về giỏ hàng
                        ->with('error', "Sản phẩm '{$productName}' không đủ số lượng tồn kho (chỉ còn {$availableQty}). Vui lòng cập nhật giỏ hàng.");
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price, // *** Lấy giá ĐÃ LƯU trong CartDetail ***
                ]);

                // Tính tổng tiền dựa trên giá ĐÃ LƯU trong CartDetail
                $totalPrice += $item->quantity * $item->price;
            }
            Log::info("Added new OrderDetails for order ID: {$order->id}. Calculated total: {$totalPrice}");

            // 7. Cập nhật tổng tiền cuối cùng cho đơn hàng
            $order->update(['total' => $totalPrice]);

            DB::commit(); // Lưu tất cả thay đổi vào database

            // 8. Lưu order_id vào session để chuyển sang trang xác nhận/thanh toán
            Session::put('order_id', $order->id);
            Session::put('processed_cart_item_ids', $selectedCartItemIds);

            // 9. Chuyển hướng đến trang xem/xác nhận đơn hàng
            // *** Đảm bảo tên route này ('order.viewOrder') khớp với định nghĩa trong web.php ***
            return redirect()->route('client.order.viewOrder');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi Checkout: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại.');
        }
    }


    public function completeOrder(Request $request)
    {
        // Kiểm tra order_id có trong session không
        $orderId = Session::get('order_id');
        $processedCartItemIds = Session::get('processed_cart_item_ids');

        if (!$orderId) {
            Session::forget('order_id');
            Session::forget('processed_cart_item_ids');
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Lấy đơn hàng từ database
        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Đơn hàng không tồn tại.');
        }

        // Cập nhật thông tin đơn hàng với dữ liệu mới từ form
        $order->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'number_house' => $request->number_house,
            'neighborhood' => $request->neighborhood,
            'district' => $request->district,
            'province' => $request->province,
            'payment_status' => $request->payment_status == 'wallet' ? 'wallet' : 'cod', // Cập nhật trạng thái thanh toán
            'status' => 'processing', // Đơn hàng được xác nhận
        ]);

        // Xoá giỏ hàng sau khi đặt hàng
        if (!empty($processedCartItemIds)) {
            $cart = Cart::where('user_id', $order->user_id)->first();
            if ($cart) {
                CartDetail::where('cart_id', $cart->id)
                    ->whereIn('id', $processedCartItemIds) // <-- Chỉ xóa các ID trong danh sách này
                    ->delete();
                Log::info("Deleted specific CartDetail IDs: " . implode(',', $processedCartItemIds) . " for cart ID: {$cart->id}");
            }
        } else {
            // Ghi log nếu không tìm thấy ID trong session, không xóa gì cả
            Log::warning("No processed_cart_item_ids found in session for order ID: {$orderId}. Cart not cleared selectively.");
        }
        // Xóa session order_id sau khi hoàn tất thanh toán
        Session::forget('order_id');
        Session::forget('processed_cart_item_ids');

        return redirect()->route('client.account.accountMyOrder')->with('success', 'Đơn hàng đã được xác nhận.');
    }


    public function applyCoupon(Request $request)
    {
        if (!Auth::check()) { /* ... */
        }

        $validator = Validator::make($request->all(), ['coupon_code' => 'required|string|max:255',]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $couponCode = strtoupper(trim($request->input('coupon_code')));
        $orderId = Session::get('order_id');

        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy thông tin đơn hàng.'], 404);
        }

        $order = Order::where('id', $orderId)->where('user_id', Auth::id())->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng không hợp lệ.'], 404);
        }
        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Không thể áp dụng mã cho đơn hàng này.'], 400);
        }
        // Quan trọng: Kiểm tra coupon hiện tại trước khi lấy total gốc
        if (!empty($order->coupon) && empty($request->input('remove_coupon'))) { // Chỉ báo lỗi nếu không phải đang cố xóa coupon cũ
            // Nếu đã có coupon và không phải đang xóa, thì không cho áp mã mới
            // Hoặc bạn có thể thêm logic xóa mã cũ trước khi áp mã mới tại đây
            return response()->json(['success' => false, 'message' => 'Chỉ áp dụng được 1 mã giảm giá mỗi đơn hàng.'], 400);
        }

        // Lấy tổng tiền gốc (quan trọng: lấy trước khi coupon có thể đã được áp dụng trước đó và ghi đè total)
        // Cách 1: Tính lại từ chi tiết đơn hàng (An toàn nhất nếu `order->total` có thể đã bị ghi đè)
        $originalTotal = $order->items()->sum(DB::raw('price * quantity'));
        // Cách 2: Giả sử `order->total` hiện tại chính là tổng gốc (chỉ đúng nếu chưa có coupon nào được áp dụng và lưu)
        // $originalTotal = $order->total;

        // Tìm Coupon
        $coupon = Coupon::where('code', $couponCode)->first();

        // --- Validate Coupon (exists, date, usage, minimum amount based on $originalTotal) ---
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không tồn tại hoặc không hợp lệ.'], 404);
        }
        $today = Carbon::now()->toDateString();
        if ($coupon->end_date < $today) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá đã hết hạn.'], 400);
        }
        if ($coupon->start_date > $today) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá chưa đến ngày sử dụng.'], 400);
        }
        if (is_numeric($coupon->number) && $coupon->number <= 0) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá này đã hết lượt sử dụng.'], 400);
        }
        if ($originalTotal < $coupon->minimum_order_amount) {
            $minAmountFormatted = number_format($coupon->minimum_order_amount);
            return response()->json(['success' => false, 'message' => "Đơn hàng chưa đạt giá trị tối thiểu ({$minAmountFormatted} VNĐ) để dùng mã này."], 400);
        }
        // --- End Coupon Validation ---

        DB::beginTransaction();
        try {
            // Tính toán số tiền giảm giá
            $discountAmount = 0;
            if ($coupon->discount_type === 'fixed') {
                $discountAmount = $coupon->discount_value;
            } elseif ($coupon->discount_type === 'percent') {
                $discountAmount = ($originalTotal * $coupon->discount_value) / 100;
            }
            $discountAmount = min($discountAmount, $originalTotal); // Đảm bảo không giảm quá tổng tiền
            $finalTotal = $originalTotal - $discountAmount; // Tổng tiền cuối cùng

            // --- Cập nhật Order ---
            $order->coupon = $coupon->code;           // Lưu mã coupon
            $order->total = $finalTotal;             // *** Ghi đè total bằng giá đã giảm ***
            // Bỏ qua $order->discount_amount và $order->final_total
            $order->save();

            // Giảm số lượt sử dụng coupon (nếu `number` là số lượt còn lại)
            if (is_numeric($coupon->number)) {
                $coupon->number = max(0, $coupon->number - 1);
                $coupon->save();
            }

            DB::commit();

            // --- Trả về JSON chứa cả giá gốc và giá mới ---
            return response()->json([
                'success' => true,
                'message' => 'Áp dụng mã giảm giá thành công!',
                'original_total_price_display' => number_format($originalTotal) . ' VNĐ', // Giá gốc để gạch ngang
                'new_total_price_display' => number_format($finalTotal) . ' VNĐ',     // Giá mới để hiển thị chính
                'coupon_code' => $coupon->code
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi Apply Coupon: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi áp dụng mã giảm giá.'], 500);
        }
    }


    public function continuePayment(Order $order, Request $request)
    {
        // 1. Kiểm tra quyền sở hữu đơn hàng
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Không có quyền truy cập.');
        }

        // 2. Kiểm tra trạng thái đơn hàng và thanh toán có phù hợp để thử lại không
        $orderStatus = strtolower($order->status ?? '');
        $paymentStatus = strtolower($order->payment_status ?? '');

        // Ví dụ: Chỉ cho thử lại khi ĐH là 'pending' và TT không phải 'cod' và không phải 'paid'
        if ($orderStatus !== 'pending' || $paymentStatus === 'cod' || $paymentStatus === 'wallet') {
            // Chuyển hướng về trang chi tiết kèm cảnh báo (Nhớ kiểm tra tên route)
            return redirect()->route('client.order.viewOrder', $order->id)
                ->with('warning', 'Đơn hàng này không thể tiếp tục thanh toán.');
        }

        // 3. === PHẦN XỬ LÝ GỌI CỔNG THANH TOÁN (Ví dụ: MoMo) SẼ THÊM VÀO ĐÂY SAU ===
        Log::info("User ID: " . Auth::id() . " yêu cầu thử lại thanh toán cho Order ID: " . $order->id . ". Logic cổng thanh toán chưa được tích hợp.");

        /*
        // ----- BẮT ĐẦU LOGIC GỌI API THANH TOÁN (MoMo, VNPay...) -----
        try {
            // 1. Lấy config của cổng thanh toán (MoMo keys...)
            // 2. Chuẩn bị dữ liệu gửi đi (ID mới, số tiền $order->total, URL callback...)
            // 3. Tạo chữ ký (signature)
            // 4. Gửi request API đến cổng thanh toán
            // 5. Nhận kết quả (payUrl hoặc lỗi)
            // 6. Nếu thành công -> return redirect()->away($payUrl);
            // 7. Nếu thất bại -> throw new \Exception("Thông báo lỗi từ cổng TT");

        } catch (\Exception $e) {
            Log::error("Lỗi Retry Payment Exception: " . $e->getMessage());
            return redirect()->route('client.order.detail', $order->id) // Check route name
                       ->with('error', 'Đã xảy ra lỗi khi thử lại thanh toán: ' . $e->getMessage());
        }
        // ----- KẾT THÚC LOGIC GỌI API THANH TOÁN -----
        */


        // --- HÀNH ĐỘNG TẠM THỜI: Chuyển hướng về trang chi tiết với thông báo ---
        // (Sau này bạn sẽ thay thế dòng này bằng logic gọi cổng thanh toán ở trên)
        // Nhớ kiểm tra tên route 'client.order.detail'
        return redirect()->route('client.order.viewOrder', $order->id)
            ->with('info', 'Chức năng thanh toán lại đang được phát triển. Vui lòng thử lại sau hoặc liên hệ hỗ trợ.');

    }
}
