<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use Auth;
use Carbon\Carbon;
use DB;
use Http;
use Illuminate\Http\Request;
use Log;
use Mail;
use Route;
use Session;
use Str;
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

        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để đặt hàng.');
        }
        $userId = Auth::id();
        $user = Auth::user();


        $validator = Validator::make($request->all(), [
            'selected_products' => [
                'required',
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


        $selectedCartItemIds = array_map('intval', explode(',', $request->input('selected_products')));


        $selectedItems = CartDetail::whereIn('id', $selectedCartItemIds)
            ->whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('productVariant')
            ->get();

        if ($selectedItems->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm được chọn trong giỏ hàng của bạn.');
        }

        DB::beginTransaction();
        try {

            do {
                $barcode = mt_rand(100000000, 999999999);
            } while (Order::where('barcode', $barcode)->exists());

            $order = Order::create([
                'user_id' => $userId,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => null,
                'number_house' => null,
                'neighborhood' => null,
                'district' => null,
                'province' => null,
                'total' => 0,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => null,
                'coupon' => null,
                'barcode' => $barcode,
            ]);
            Log::info("Created new pending order ID: {$order->id} for user ID: {$userId}");

            $totalPrice = 0;

            foreach ($selectedItems as $item) {
                if (!$item->productVariant || $item->productVariant->quantity < $item->quantity) {
                    DB::rollBack();
                    $productName = $item->productVariant->products->name ?? 'Sản phẩm';
                    $availableQty = $item->productVariant->quantity ?? 0;
                    return redirect()->route('cart.viewCart')
                        ->with('error', "Sản phẩm '{$productName}' không đủ số lượng tồn kho (chỉ còn {$availableQty}). Vui lòng cập nhật giỏ hàng.");
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                $totalPrice += $item->quantity * $item->price;
            }
            Log::info("Added new OrderDetails for order ID: {$order->id}. Calculated total: {$totalPrice}");

            $order->update(['total' => $totalPrice]);

            if (!empty($selectedCartItemIds)) {
                CartDetail::whereIn('id', $selectedCartItemIds)
                    ->whereHas('cart', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                    ->update(['status' => 'checkout']);
                Log::info("Marked CartDetail IDs as 'checkout' for Order {$order->id}: " . implode(',', $selectedCartItemIds));
            }

            if (!empty($selectedCartItemIds)) {
                // Lưu danh sách ID (đã lấy ở đầu hàm) vào cột tạm dưới dạng JSON
                $order->temporary_cart_ids = json_encode($selectedCartItemIds);
                $order->save(); // Lưu lại lần nữa để cập nhật cột này
                Log::info("Đã lưu temporary_cart_ids vào Order ID {$order->id}");
            } else {
                // Ghi log nếu không có ID nào được chọn (trường hợp hiếm sau validation)
                Log::warning("Không tìm thấy selectedCartItemIds để lưu trong checkout cho Order {$order->id}.");
                // Cân nhắc: Có nên throw Exception ở đây không?
            }

            DB::commit();

            Session::put('order_id', $order->id);

            return redirect()->route('client.order.viewOrder');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi Checkout: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại.');
        }
    }


    public function completeOrder(Request $request)
    {
        $user = Auth::user();
        // 1. Lấy thông tin từ Session và kiểm tra
        $orderId = Session::get('order_id');
        $processedCartItemIds = Session::get('processed_cart_item_ids');
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập.');
        }
        if (!$orderId) { /* ... xử lý lỗi session ... */
            return redirect()->route('client.cart.viewCart')->with('error', '...');
        } // Check route name

        // 2. Tìm đơn hàng và kiểm tra
        $order = Order::find($orderId);
        if (!$order || $order->user_id !== Auth::id() || $order->status !== 'pending') { /* ... xử lý lỗi đơn hàng ... */
            return redirect()->route('client.cart.viewCart')->with('error', '...');
        } // Check route name

        // 3. Validate dữ liệu form
        $validator = Validator::make($request->all(), [ /* ... validation rules ... */]);
        if ($validator->fails()) { /* ... redirect back with errors ... */
            return redirect()->route('client.order.viewOrder')->withErrors($validator)->withInput();
        } // Check route name

        // 4. Bắt đầu Transaction
        DB::beginTransaction();
        try {
            // 5. Cập nhật thông tin chung vào đơn hàng
            $user->name = $request->input('name');
            $order->phone = $request->input('phone');
            $order->email = $request->input('email');
            $order->address = $request->input('address');
            $order->number_house = $request->input('number_house');
            $order->neighborhood = $request->input('neighborhood');
            $order->district = $request->input('district');
            $order->province = $request->input('province');
            $order->payment_method = $request->input('payment_method'); // 'cod' hoặc 'wallet'
            $order->save(); // Lưu thông tin người dùng, payment_status

            // 6. Xử lý theo phương thức thanh toán
            if ($order->payment_method === 'cod') {
                // ----- XỬ LÝ COD (Như cũ) -----
                $order->status = 'processing';
                $order->save();
                $cart = Cart::where('user_id', $order->user_id)->first();

                if ($cart) {
                    $deletedCount = CartDetail::where('cart_id', $cart->id)
                        ->where('status', 'checkout')
                        ->delete();
                    Log::info("COD Order {$order->id}: Deleted {$deletedCount} 'checkout' status CartDetail items for Cart ID {$cart->id}.");
                }

                DB::commit();
                Session::forget('order_id');

                try {
                    $order->loadMissing(['items.product', 'items.productVariant']);
                    Mail::to($order->email)->send(new OrderPlacedMail($order));
                    Log::info("Sent OrderPlacedMail for COD Order ID {$order->id} to {$order->email}");
                } catch (\Exception $e) {
                    Log::error("Failed to send OrderPlacedMail for Order ID {$order->id}: " . $e->getMessage());
                }

                return redirect()->route('client.account.accountMyOrder')->with('success', 'Đơn hàng đã được đặt thành công! Vui lòng chờ admin xác nhận.'); // Check route name

            } elseif ($order->payment_method === 'wallet') {
                // ----- XỬ LÝ MOMO SANDBOX -----
                // Status vẫn là 'pending' đến khi có IPN
                if (!empty($processedCartItemIds)) {
                    $order->temporary_cart_ids = json_encode($processedCartItemIds); // Lưu dưới dạng JSON
                    $order->save(); // Lưu lại order với thông tin này
                    Log::info("Saved temporary cart item IDs to Order {$order->id}");
                } else {
                    // Nếu không có ID nào được xử lý thì không nên tiếp tục MoMo? Hoặc ghi log.
                    Log::warning("No processed_cart_item_ids found in session for MoMo payment initiation for Order {$order->id}.");
                    // Có thể throw exception ở đây nếu đây là lỗi nghiêm trọng
                    // throw new \Exception('Lỗi: Không có sản phẩm để thanh toán MoMo.');
                }
                // --- Lấy cấu hình MoMo Sandbox ---
                $momoConfig = config('services.momo');
                if (empty($momoConfig['sandbox_partner_code']) || empty($momoConfig['sandbox_access_key']) || empty($momoConfig['sandbox_secret_key']) || empty($momoConfig['sandbox_endpoint_url'])) {
                    throw new \Exception('Lỗi cấu hình MoMo Sandbox.');
                }
                $partnerCode = $momoConfig['sandbox_partner_code'];
                $accessKey = $momoConfig['sandbox_access_key'];
                $secretKey = $momoConfig['sandbox_secret_key'];
                $endpoint = $momoConfig['sandbox_endpoint_url'];

                // --- Chuẩn bị URLs ---
                $returnRouteName = 'momo.return'; // Đảm bảo route này tồn tại
                $notifyRouteName = 'momo.notify'; // Đảm bảo route này tồn tại
                if (!Route::has($returnRouteName) || !Route::has($notifyRouteName)) {
                    throw new \Exception('Lỗi cấu hình URL MoMo.');
                }
                $redirectUrl = route($returnRouteName);
                // $ipnUrl = route($notifyRouteName);
                // --- Thay đổi TẠM THỜI cho testing ---
                $ngrokForwardingUrl = "https://b8c4-2001-ee0-40e1-b7bf-fce7-5306-f1f4-1a27.ngrok-free.app"; // <<-- DÁN URL NGROK HTTPS CỦA BẠN VÀO ĐÂY
                $ipnRouteUri = "/momo/payment/notify"; // <<-- Đảm bảo đây là URI bạn định nghĩa trong routes/web.php
                $ipnUrl = $ngrokForwardingUrl . $ipnRouteUri;
                Log::info('Using temporary Ngrok IPN URL: ' . $ipnUrl); // Log để kiểm tra
// --- Kết thúc thay đổi tạm thời ---

                // --- Chuẩn bị Tham số ---
                $amount = (string) round($order->total); // Dùng total cuối cùng (đã gồm discount)
                $orderInfo = "Thanh toan don hang " . ($order->barcode ?? $order->id);
                $requestId = (string) Str::uuid(); // ID duy nhất cho request API này
                $momoOrderId = $order->id . "_" . $requestId; // ID đơn hàng *riêng* cho giao dịch MoMo này
                $requestType = "payWithATM"; // Kiểm tra lại loại request type phù hợp với MoMo Gateway/Sandbox
                $extraData = ""; // Dữ liệu thêm nếu cần (base64 encode json)

                // --- Tạo Chuỗi Signature (THỨ TỰ QUAN TRỌNG - XEM DOCS MOMO!) ---
                // Ví dụ, bạn cần kiểm tra lại chính xác với tài liệu MoMo Sandbox
                $rawHash = "accessKey=" . $accessKey .
                    "&amount=" . $amount .
                    "&extraData=" . $extraData .
                    "&ipnUrl=" . $ipnUrl .
                    "&orderId=" . $momoOrderId . // Dùng ID mới tạo cho MoMo
                    "&orderInfo=" . $orderInfo .
                    "&partnerCode=" . $partnerCode .
                    "&redirectUrl=" . $redirectUrl .
                    "&requestId=" . $requestId .
                    "&requestType=" . $requestType;

                $signature = hash_hmac('sha256', $rawHash, $secretKey);

                // --- Chuẩn bị Body Request ---
                $requestBody = [
                    'partnerCode' => $partnerCode,
                    'requestId' => $requestId,
                    'amount' => $amount,
                    'orderId' => $momoOrderId,
                    'orderInfo' => $orderInfo,
                    'redirectUrl' => $redirectUrl,
                    'ipnUrl' => $ipnUrl,
                    'requestType' => $requestType,
                    'extraData' => $extraData,
                    'lang' => 'vi',
                    'signature' => $signature,
                    // 'partnerName' => "Test", // Bỏ đi nếu không cần thiết
                    // "storeId" => "MomoTestStore", // Bỏ đi nếu không cần thiết
                ];

                Log::info("MoMo Payment Request (completeOrder) to [{$endpoint}]: ", $requestBody);

                // --- Gửi API Request ---
                $response = Http::timeout(30)->post($endpoint, $requestBody);

                // --- Xử lý Response ---
                if ($response->failed()) {
                    Log::error("MoMo API Call Failed (completeOrder). Status: " . $response->status(), ['body' => $response->body()]);
                    throw new \Exception("Kết nối MoMo thất bại.");
                }
                $momoResult = $response->json();
                Log::info("MoMo Payment Response (completeOrder): ", $momoResult);

                // Kiểm tra mã lỗi MoMo (ví dụ: resultCode = 0 là thành công) - XEM DOCS MOMO!
                if (isset($momoResult['resultCode']) && $momoResult['resultCode'] == 0 && !empty($momoResult['payUrl'])) {
                    // Thành công -> Lưu các thay đổi thông tin đơn hàng vào DB
                    DB::commit();
                    Log::info("Order {$order->id} info updated (payment pending wallet), redirecting to MoMo payUrl...");
                    // Chuyển hướng sang MoMo, KHÔNG xóa session/cart items vội
                    return redirect()->away($momoResult['payUrl']);
                } else {
                    // Gọi MoMo thất bại -> Ném lỗi để rollback và báo lỗi về view
                    $errorMessage = $momoResult['message'] ?? 'Khởi tạo thanh toán MoMo không thành công.';
                    throw new \Exception("Lỗi từ MoMo: " . $errorMessage);
                }
            } else {
                DB::rollBack();
                return redirect()->route('client.order.viewOrder')->with('error', 'Phương thức thanh toán không hợp lệ.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi completeOrder Exception for Order ID {$orderId}: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            // Quay lại trang thanh toán báo lỗi
            return redirect()->route('client.order.viewOrder')->with('error', 'Đã xảy ra lỗi khi xử lý đơn hàng: ' . $e->getMessage()); // Check route name
        }
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
            abort(403, 'Không có quyền truy cập đơn hàng này.');
        }

        // 2. Kiểm tra trạng thái đơn hàng và thanh toán
        $orderStatus = strtolower($order->status ?? '');
        if ($orderStatus !== 'pending') {
            return redirect()->route('client.account.accountOrderDetail', $order->id)
                ->with('warning', 'Đơn hàng này không còn ở trạng thái chờ thanh toán.');
        }

        $paymentMethod = strtolower($order->payment_method ?? '');
        $paymentStatus = strtolower($order->payment_status ?? '');


        if (is_null($order->payment_method) || $paymentMethod === '') {
            Log::info("User continuing Order {$order->id} with null payment_method. Restoring session for viewOrder.");

            $cartItemIdsJson = $order->temporary_cart_ids ?? '[]';
            $cartItemIds = json_decode($cartItemIdsJson, true);

            if (!empty($cartItemIds) && is_array($cartItemIds)) {
                Session::put('order_id', $order->id);
                Session::put('processed_cart_item_ids', $cartItemIds);
                Log::info("Restored session for Order {$order->id} before redirecting to viewOrder.");
                return redirect()->route('client.order.viewOrder');

            } else {
                Log::error("Cannot continue Order {$order->id}: Missing temporary_cart_ids to reconstruct viewOrder session.");
                Session::forget('order_id');
                return redirect()->route('client.cart.viewCart')
                    ->with('error', 'Đã có lỗi xảy ra khi tiếp tục đơn hàng này. Vui lòng thử lại từ giỏ hàng.');
            }
        }

        // Chỉ cho phép thử lại khi: ĐH là 'pending', Phương thức là 'wallet', và TT là 'pending' (hoặc 'failed'?)
        // Thêm 'failed' vào nếu bạn muốn cho phép thử lại sau khi thanh toán thất bại
        $allowedPaymentStatuses = ['pending', 'failed'];
        if ($orderStatus !== 'pending' || !in_array($paymentStatus, $allowedPaymentStatuses) || $paymentMethod !== 'wallet') {
            // Kiểm tra lại tên route trang chi tiết đơn hàng client
            return redirect()->route('client.account.accountOrderDetail', $order->id)
                ->with('warning', 'Đơn hàng này không thể tiếp tục thanh toán.');
        }

        // 3. === LOGIC GỌI LẠI API MOMO SANDBOX ===
        // IMPORTANT: Đảm bảo logic này khớp với MoMo Docs và cấu hình của bạn
        try {
            // --- Lấy cấu hình MoMo Sandbox ---
            $momoConfig = config('services.momo');
            if (empty($momoConfig['sandbox_partner_code']) || empty($momoConfig['sandbox_access_key']) || empty($momoConfig['sandbox_secret_key']) || empty($momoConfig['sandbox_endpoint_url'])) {
                throw new \Exception('Lỗi cấu hình MoMo Sandbox.');
            }
            $partnerCode = $momoConfig['sandbox_partner_code'];
            $accessKey = $momoConfig['sandbox_access_key'];
            $secretKey = $momoConfig['sandbox_secret_key'];
            $endpoint = $momoConfig['sandbox_endpoint_url']; // Kiểm tra URL endpoint


            $returnRouteName = 'momo.return'; // Đảm bảo route này tồn tại
            $notifyRouteName = 'momo.notify'; // Đảm bảo route này tồn tại
            if (!Route::has($returnRouteName) || !Route::has($notifyRouteName)) {
                throw new \Exception('Lỗi cấu hình URL MoMo.');
            }
            $redirectUrl = route($returnRouteName);
            // $ipnUrl = route($notifyRouteName);
            // --- Thay đổi TẠM THỜI cho testing ---
            $ngrokForwardingUrl = "https://b8c4-2001-ee0-40e1-b7bf-fce7-5306-f1f4-1a27.ngrok-free.app"; // <<-- DÁN URL NGROK HTTPS CỦA BẠN VÀO ĐÂY
            $ipnRouteUri = "/momo/payment/notify"; // <<-- Đảm bảo đây là URI bạn định nghĩa trong routes/web.php
            $ipnUrl = $ngrokForwardingUrl . $ipnRouteUri;
            Log::info('Using temporary Ngrok IPN URL: ' . $ipnUrl); // Log để kiểm tra


            // --- Chuẩn bị Tham số MoMo (Tạo ID mới cho lần thử lại) ---
            $amount = (string) round($order->total); // Vẫn dùng total cuối cùng của đơn hàng
            $orderInfo = "Tiep tuc thanh toan don hang " . ($order->barcode ?? $order->id);
            $requestId = (string) Str::uuid(); // <<-- Request ID MỚI
            $momoOrderId = $order->id . "_" . $requestId; // <<-- MoMo Order ID MỚI
            $requestType = "payWithATM"; // <<-- Hoặc "captureWallet" - KIỂM TRA LẠI VỚI DOCS MOMO
            $extraData = "";

            // --- Tạo Chuỗi Signature (KIỂM TRA LẠI THAM SỐ & THỨ TỰ VỚI DOCS MOMO!) ---
            $rawHash = "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$momoOrderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
            $signature = hash_hmac('sha256', $rawHash, $secretKey);

            // --- Chuẩn bị Request Body (KIỂM TRA LẠI TRƯỜNG VỚI DOCS MOMO!) ---
            $requestBody = ['partnerCode' => $partnerCode, 'requestId' => $requestId, 'amount' => $amount, 'orderId' => $momoOrderId, 'orderInfo' => $orderInfo, 'redirectUrl' => $redirectUrl, 'ipnUrl' => $ipnUrl, 'requestType' => $requestType, 'extraData' => $extraData, 'lang' => 'vi', 'signature' => $signature];
            Log::info("MoMo Continue Payment Request to [{$endpoint}]: ", $requestBody);

            // --- Gửi API Request ---
            $response = Http::timeout(30)->post($endpoint, $requestBody);

            // --- Xử lý Response ---
            if ($response->failed()) {
                Log::error("MoMo Continue API Call Failed. Status: " . $response->status(), ['body' => $response->body()]);
                throw new \Exception("Kết nối đến MoMo thất bại khi thử lại thanh toán.");
            }
            $momoResult = $response->json();
            Log::info("MoMo Continue Payment Response: ", $momoResult);

            // Kiểm tra mã lỗi MoMo (Ví dụ resultCode = 0 là thành công)
            if (isset($momoResult['resultCode']) && $momoResult['resultCode'] == 0 && !empty($momoResult['payUrl'])) {
                // Thành công -> Chuyển hướng người dùng sang MoMo payUrl mới
                Log::info("Redirecting user to MoMo payUrl for retrying Order ID {$order->id}, MoMo Order ID {$momoOrderId}");
                // KHÔNG CẦN LÀM GÌ VỚI DATABASE Ở ĐÂY
                return redirect()->away($momoResult['payUrl']);
            } else {
                // Lỗi từ MoMo
                $errorMessage = $momoResult['message'] ?? 'Thử lại thanh toán MoMo không thành công.';
                throw new \Exception("Lỗi từ MoMo: " . $errorMessage);
            }

        } catch (\Exception $e) {
            Log::error("Lỗi continuePayment Exception for Order ID {$order->id}: " . $e->getMessage());
            // Quay về trang chi tiết báo lỗi
            // Kiểm tra lại tên route 'client.order.detail' hoặc 'client.account.accountOrderDetail'
            return redirect()->route('client.account.accountOrderDetail', $order->id)
                ->with('error', 'Đã xảy ra lỗi khi thử lại thanh toán: ' . $e->getMessage());
        }
    }


    public function cancelOrder(Order $order, Request $request)
    {
        // 1. Kiểm tra quyền: Chỉ chủ đơn hàng mới được hủy
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Bạn không có quyền hủy đơn hàng này.');
        }

        // 2. Kiểm tra trạng thái: Chỉ cho hủy khi đang 'pending' hoặc 'processing'
        $cancellableStatuses = ['pending', 'processing']; // Các trạng thái cho phép hủy
        if (!in_array(strtolower($order->status ?? ''), $cancellableStatuses)) {
            // Kiểm tra lại tên route chi tiết đơn hàng của client
            return redirect()->route('client.order.detail', $order->id)
                ->with('error', 'Đơn hàng này không thể hủy ở trạng thái hiện tại.');
        }

        // 3. Bắt đầu Transaction
        DB::beginTransaction();
        try {
            $originalStatus = $order->status; // Lưu lại trạng thái cũ (để ghi log)

            // 4. Hoàn trả tồn kho
            // Tải lại items và productVariant để đảm bảo dữ liệu mới nhất và tránh N+1
            $order->load('items.productVariant');

            foreach ($order->items as $item) {
                if ($variant = $item->productVariant) {
                    // Cộng trả lại số lượng vào kho dùng increment cho an toàn
                    $variant->increment('quantity', $item->quantity);
                    Log::info("Hoàn kho Variant ID {$variant->id} +{$item->quantity} do hủy Order ID {$order->id}.");
                } else {
                    Log::warning("Không tìm thấy Variant ID {$item->product_variant_id} để hoàn kho khi hủy Order ID {$order->id}.");
                    // Cân nhắc: Có nên rollback transaction nếu không hoàn kho được không?
                    // throw new \Exception("Lỗi hoàn kho cho sản phẩm trong đơn hàng.");
                }
            }

            // 5. Cập nhật trạng thái đơn hàng thành 'cancelled'
            $order->status = 'cancelled';
            // Lưu thời gian hủy nếu có cột cancelled_at
            $order->cancelled_at = now();
            // Thêm ghi chú hủy đơn
            $order->note = ($order->note ? $order->note . "\n" : '') . 'Đơn hàng được hủy bởi khách hàng';
            $order->save();

            // 6. Commit Transaction
            DB::commit();

            Log::info("Order ID {$order->id} cancelled successfully by User ID " . Auth::id());

            // 7. Chuyển hướng về trang chi tiết kèm thông báo thành công
            // Kiểm tra lại tên route chi tiết đơn hàng của client
            return redirect()->route('client.account.accountOrderDetail', $order->id)
                ->with('success', 'Đơn hàng đã được hủy thành công.');

        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác nếu có lỗi
            Log::error("Lỗi khi hủy Order ID {$order->id} bởi User ID " . Auth::id() . ": " . $e->getMessage());
            // Chuyển hướng về trang chi tiết báo lỗi
            // Kiểm tra lại tên route chi tiết đơn hàng của client
            return redirect()->route('client.account.accountOrderDetail', $order->id)
                ->with('error', 'Đã xảy ra lỗi khi hủy đơn hàng. Vui lòng thử lại.');
        }
    }

}
