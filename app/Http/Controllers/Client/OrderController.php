<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Province;
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
            // Chuyển hướng về trang đăng nhập nếu chưa login
            return redirect()->route('client.viewLogin')->with('warning', 'Vui lòng đăng nhập để đặt hàng.');
        }

        $user = Auth::user(); // Lấy user hiện tại

        // Lấy orderId từ session (như code bạn đã có)
        $orderId = Session::get('order_id');

        // Lấy đơn hàng (như code bạn đã có)
        $order = Order::with('items.product')->find($orderId);

        // Kiểm tra order có tồn tại không (như code bạn đã có)
        if (!$order) {
            Session::forget('order_id'); // Xóa order_id cũ nếu không tìm thấy order
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        // <<< BẮT ĐẦU: Lấy dữ liệu địa chỉ và các items/tổng tiền cho view >>>

        // Lấy thông tin địa chỉ đã lưu của người dùng
        // Điều chỉnh dựa trên cách bạn lưu địa chỉ user
        // Giả định các cột địa chỉ (province_code, district_code, ward_code, address) lưu trên model User
        // Nếu lưu ở model UserAddress, cần fetch userAddress = UserAddress::where('user_id', $user->id)->first();
        $userAddress = $user; // Giả định các cột địa chỉ lưu trực tiếp trên model User

        // Lấy danh sách tất cả tỉnh/thành phố từ database bạn đã cung cấp
        $provinces = Province::orderBy('full_name', 'asc')->get();

        // Lấy cart items và tổng tiền tương tự như trong CartController@viewCart
        // (Bạn có thể đã có các biến này nếu chuyển hướng từ cart checkout POST)
        // Nếu không có, cần fetch lại dựa trên order items:
        $cartItems = $order->items; // Lấy items từ order đã load
        // Tính lại tổng tiền dựa trên order->total đã lưu hoặc từ items
        $totalPrice = $order->total ?? $cartItems->sum(function ($item) {
            return ($item->quantity ?? 0) * ($item->price ?? 0);
        });

        return view('client.order.order')->with([
            'order' => $order,
            'totalPrice' => $totalPrice,
            'user' => $user,
            'userAddress' => $userAddress,
            'provinces' => $provinces
        ]);
    }


    public function checkout(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để đặt hàng.');
        }
        $userId = Auth::id();
        $user = Auth::user(); // Lấy thông tin user đang đăng nhập
        // 2. Validate input chứa ID sản phẩm được chọn từ giỏ hàng
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
        // dd($validator);
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
                // Lấy thông tin cơ bản từ user đăng nhập, không lấy từ request ở bước này
                // 'name' => $user->name, // Giả sử User model có 'name'
                'email' => $user->email, // Giả sử User model có 'email'
                'phone' => $user->phone, // Giả sử User model có 'phone'
                // Địa chỉ chi tiết sẽ được cập nhật ở bước 'completeOrder'
                'name' => $user->name,
                'address' => null,
                'ward_code' => null,
                'district_code' => null,
                'province_code' => null,
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
                    return redirect()->route('client.cart.viewCart'); // Quay về giỏ hàng
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
                $order->temporary_cart_ids = json_encode($selectedCartItemIds);
                $order->save();
                Log::info("Đã lưu temporary_cart_ids vào Order ID {$order->id}");
            } else {
                Log::warning("Không tìm thấy selectedCartItemIds để lưu trong checkout cho Order {$order->id}.");
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
        $orderId = Session::get('order_id');
        $processedCartItemIds = Session::get('processed_cart_item_ids');
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập.');
        }
        if (!$orderId) {
            return redirect()->route('client.cart.viewCart')->with('error', '...');
        }

        $order = Order::find($orderId);
        if (!$order || $order->user_id !== Auth::id() || $order->status !== 'pending') {
            return redirect()->route('client.cart.viewCart')->with('error', '...');
        }

        $validator = Validator::make($request->all(), []);
        if ($validator->fails()) {
            return redirect()->route('client.order.viewOrder')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $user->name = $request->input('name');
            $order->phone = $request->input('phone');
            $order->email = $request->input('email');
            $order->address = $request->input('address');
            $order->ward_code = $request->input('ward_code');
            $order->district_code = $request->input('district_code');
            $order->province_code = $request->input('province_code');
            $order->payment_method = $request->input('payment_method');
            $order->save();

            foreach ($order->items as $item) {
                // Lấy biến thể sản phẩm TỪ DATABASE VỚI LOCK
                // Lock đảm bảo không có user khác trừ tồn kho cùng lúc cho biến thể này
                $variant = \App\Models\ProductVariant::find($item->product_variant_id); // Find lại variant
                if (!$variant) {
                    // Xử lý nếu biến thể không tồn tại (rất hiếm nếu data đúng)
                    DB::rollBack();
                    Log::error("Checkout failed: ProductVariant ID {$item->product_variant_id} not found for Order Item {$item->id} in Order {$order->id}.");
                    return redirect()->route('client.order.viewOrder')->with('error', 'Đã xảy ra lỗi với một số sản phẩm trong đơn hàng.');
                }

                // >>> KIỂM TRA LẠI TỒN KHO CUỐI CÙNG NGAY TRƯỚC KHI TRỪ <<<
                // Kiểm tra xem số lượng tồn kho hiện tại có đủ cho số lượng user muốn mua không
                if ($variant->quantity < $item->quantity) {
                    DB::rollBack(); // Rollback toàn bộ transaction
                    Log::warning("Checkout failed: Insufficient stock for Variant ID {$variant->id}. Required: {$item->quantity}, Available: {$variant->quantity}. Order ID: {$order->id}");

                    // Cần xóa item này khỏi order hoặc đánh dấu nó không hợp lệ
                    // hoặc chuyển hướng user về giỏ hàng với thông báo lỗi sản phẩm hết hàng
                    // Ví dụ: Xóa item khỏi order và thông báo lỗi
                    $item->delete(); // Xóa item khỏi order (hoặc đánh dấu invalid)
                    // Tải lại order để tổng tiền hiển thị đúng sau khi xóa item lỗi (tùy chọn)
                    // $order->load('items');
                    // Session::put('order_id', $order->id); // Có thể cần cập nhật session order_id nếu item bị xóa/thay đổi

                    return redirect()->route('client.order.viewOrder')
                        ->with('error', "Sản phẩm \"{$variant->name}\" (Màu: {$variant->name_variant_color}, Size: {$variant->name_variant_size}) trong đơn hàng không đủ số lượng tồn kho ({$variant->quantity}).")
                        ->with('order_id', $order->id); // Pass order_id lại session để user xem lại giỏ/checkout mới

                }

                // >>> TRỪ SỐ LƯỢNG TỒN KHO THỰC TẾ <<<
                $variant->quantity -= $item->quantity; // Trừ số lượng đã mua khỏi tồn kho chính
                $variant->save(); // Lưu thay đổi tồn kho
                Log::info("Stock deducted: Variant ID {$variant->id} stock reduced by {$item->quantity}. New stock: {$variant->quantity}. Order ID: {$order->id}");

            }

            if ($order->payment_method === 'cod') {
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

                return redirect()->route('client.account.accountMyOrder')->with('success', 'Đơn hàng đã được đặt thành công! Vui lòng chờ admin xác nhận.');

            } elseif ($order->payment_method === 'wallet') {
                if (!empty($processedCartItemIds)) {
                    $order->temporary_cart_ids = json_encode($processedCartItemIds);
                    $order->save();
                    Log::info("Saved temporary cart item IDs to Order {$order->id}");
                } else {
                    Log::warning("No processed_cart_item_ids found in session for MoMo payment initiation for Order {$order->id}.");
                }
                $momoConfig = config('services.momo');
                if (empty($momoConfig['sandbox_partner_code']) || empty($momoConfig['sandbox_access_key']) || empty($momoConfig['sandbox_secret_key']) || empty($momoConfig['sandbox_endpoint_url'])) {
                    throw new \Exception('Lỗi cấu hình MoMo Sandbox.');
                }
                $partnerCode = $momoConfig['sandbox_partner_code'];
                $accessKey = $momoConfig['sandbox_access_key'];
                $secretKey = $momoConfig['sandbox_secret_key'];
                $endpoint = $momoConfig['sandbox_endpoint_url'];

                $returnRouteName = 'momo.return';
                $notifyRouteName = 'momo.notify';
                if (!Route::has($returnRouteName) || !Route::has($notifyRouteName)) {
                    throw new \Exception('Lỗi cấu hình URL MoMo.');
                }
                $redirectUrl = route($returnRouteName);

                // Sử dụng ngrok
                $ngrokForwardingUrl = "https://e049-2001-ee0-40e1-7d37-61dd-fac7-76fb-f2a1.ngrok-free.app";
                $ipnRouteUri = "/momo/payment/notify";
                $ipnUrl = $ngrokForwardingUrl . $ipnRouteUri;
                Log::info('Using temporary Ngrok IPN URL: ' . $ipnUrl);

                $amount = (string) round($order->total);
                $orderInfo = "Thanh toan don hang " . ($order->barcode ?? $order->id);
                $requestId = (string) Str::uuid();
                $momoOrderId = $order->id . "_" . $requestId;
                $requestType = "payWithATM";
                $extraData = "";

                $rawHash = "accessKey=" . $accessKey .
                    "&amount=" . $amount .
                    "&extraData=" . $extraData .
                    "&ipnUrl=" . $ipnUrl .
                    "&orderId=" . $momoOrderId .
                    "&orderInfo=" . $orderInfo .
                    "&partnerCode=" . $partnerCode .
                    "&redirectUrl=" . $redirectUrl .
                    "&requestId=" . $requestId .
                    "&requestType=" . $requestType;

                $signature = hash_hmac('sha256', $rawHash, $secretKey);

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
                ];

                Log::info("MoMo Payment Request (completeOrder) to [{$endpoint}]: ", $requestBody);

                $response = Http::timeout(30)->post($endpoint, $requestBody);

                if ($response->failed()) {
                    Log::error("MoMo API Call Failed (completeOrder). Status: " . $response->status(), ['body' => $response->body()]);
                    throw new \Exception("Kết nối MoMo thất bại.");
                }
                $momoResult = $response->json();
                Log::info("MoMo Payment Response (completeOrder): ", $momoResult);

                if (isset($momoResult['resultCode']) && $momoResult['resultCode'] == 0 && !empty($momoResult['payUrl'])) {
                    DB::commit();
                    Log::info("Order {$order->id} info updated (payment pending wallet), redirecting to MoMo payUrl...");
                    return redirect()->away($momoResult['payUrl']);
                } else {
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
            return redirect()->route('client.order.viewOrder')->with('error', 'Đã xảy ra lỗi khi xử lý đơn hàng: ' . $e->getMessage());
        }
    }


    public function applyCoupon(Request $request)
    {
        if (!Auth::check()) {
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
        if (!empty($order->coupon) && empty($request->input('remove_coupon'))) {
            return response()->json(['success' => false, 'message' => 'Chỉ áp dụng được 1 mã giảm giá mỗi đơn hàng.'], 400);
        }

        $originalTotal = $order->items()->sum(DB::raw('price * quantity'));

        $coupon = Coupon::where('code', $couponCode)->first();

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

        DB::beginTransaction();
        try {
            $discountAmount = 0;
            if ($coupon->discount_type === 'fixed') {
                $discountAmount = $coupon->discount_value;
            } elseif ($coupon->discount_type === 'percent') {
                $discountAmount = ($originalTotal * $coupon->discount_value) / 100;
            }
            $discountAmount = min($discountAmount, $originalTotal);
            $finalTotal = $originalTotal - $discountAmount;

            $order->coupon = $coupon->code;
            $order->total = $finalTotal;
            $order->save();

            if (is_numeric($coupon->number)) {
                $coupon->number = max(0, $coupon->number - 1);
                $coupon->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Áp dụng mã giảm giá thành công!',
                'original_total_price_display' => number_format($originalTotal) . ' VNĐ',
                'new_total_price_display' => number_format($finalTotal) . ' VNĐ',
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
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Không có quyền truy cập đơn hàng này.');
        }

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

        $allowedPaymentStatuses = ['pending', 'failed'];
        if ($orderStatus !== 'pending' || !in_array($paymentStatus, $allowedPaymentStatuses) || $paymentMethod !== 'wallet') {
            return redirect()->route('client.account.accountOrderDetail', $order->id)
                ->with('warning', 'Đơn hàng này không thể tiếp tục thanh toán.');
        }

        try {
            $momoConfig = config('services.momo');
            if (empty($momoConfig['sandbox_partner_code']) || empty($momoConfig['sandbox_access_key']) || empty($momoConfig['sandbox_secret_key']) || empty($momoConfig['sandbox_endpoint_url'])) {
                throw new \Exception('Lỗi cấu hình MoMo Sandbox.');
            }
            $partnerCode = $momoConfig['sandbox_partner_code'];
            $accessKey = $momoConfig['sandbox_access_key'];
            $secretKey = $momoConfig['sandbox_secret_key'];
            $endpoint = $momoConfig['sandbox_endpoint_url'];


            $returnRouteName = 'momo.return';
            $notifyRouteName = 'momo.notify';
            if (!Route::has($returnRouteName) || !Route::has($notifyRouteName)) {
                throw new \Exception('Lỗi cấu hình URL MoMo.');
            }
            $redirectUrl = route($returnRouteName);
            // Sử dụng ngrok
            $ngrokForwardingUrl = "https://e049-2001-ee0-40e1-7d37-61dd-fac7-76fb-f2a1.ngrok-free.app";
            $ipnRouteUri = "/momo/payment/notify";
            $ipnUrl = $ngrokForwardingUrl . $ipnRouteUri;
            Log::info('Using temporary Ngrok IPN URL: ' . $ipnUrl);


            $amount = (string) round($order->total);
            $orderInfo = "Tiep tuc thanh toan don hang " . ($order->barcode ?? $order->id);
            $requestId = (string) Str::uuid();
            $momoOrderId = $order->id . "_" . $requestId;
            $requestType = "payWithATM";
            $extraData = "";

            $rawHash = "accessKey={$accessKey}&amount={$amount}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$momoOrderId}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
            $signature = hash_hmac('sha256', $rawHash, $secretKey);

            $requestBody = ['partnerCode' => $partnerCode, 'requestId' => $requestId, 'amount' => $amount, 'orderId' => $momoOrderId, 'orderInfo' => $orderInfo, 'redirectUrl' => $redirectUrl, 'ipnUrl' => $ipnUrl, 'requestType' => $requestType, 'extraData' => $extraData, 'lang' => 'vi', 'signature' => $signature];
            Log::info("MoMo Continue Payment Request to [{$endpoint}]: ", $requestBody);

            $response = Http::timeout(30)->post($endpoint, $requestBody);

            if ($response->failed()) {
                Log::error("MoMo Continue API Call Failed. Status: " . $response->status(), ['body' => $response->body()]);
                throw new \Exception("Kết nối đến MoMo thất bại khi thử lại thanh toán.");
            }
            $momoResult = $response->json();
            Log::info("MoMo Continue Payment Response: ", $momoResult);

            if (isset($momoResult['resultCode']) && $momoResult['resultCode'] == 0 && !empty($momoResult['payUrl'])) {
                Log::info("Redirecting user to MoMo payUrl for retrying Order ID {$order->id}, MoMo Order ID {$momoOrderId}");
                return redirect()->away($momoResult['payUrl']);
            } else {
                $errorMessage = $momoResult['message'] ?? 'Thử lại thanh toán MoMo không thành công.';
                throw new \Exception("Lỗi từ MoMo: " . $errorMessage);
            }

        } catch (\Exception $e) {
            Log::error("Lỗi continuePayment Exception for Order ID {$order->id}: " . $e->getMessage());
            return redirect()->route('client.account.accountOrderDetail', $order->id)
                ->with('error', 'Đã xảy ra lỗi khi thử lại thanh toán: ' . $e->getMessage());
        }
    }


    public function cancelOrder(Order $order, Request $request)
    {
        if (Auth::id() !== $order->user_id) {
            abort(403, 'Bạn không có quyền hủy đơn hàng này.');
        }

        $cancellableStatuses = ['pending', 'processing'];
        if (!in_array(strtolower($order->status ?? ''), $cancellableStatuses)) {
            return redirect()->route('client.order.detail', $order->id)
                ->with('error', 'Đơn hàng này không thể hủy ở trạng thái hiện tại.');
        }

        DB::beginTransaction();
        try {
            $originalStatus = $order->status;

            $order->load('items.productVariant');

            foreach ($order->items as $item) {
                if ($variant = $item->productVariant) {
                    $variant->increment('quantity', $item->quantity);
                    Log::info("Hoàn kho Variant ID {$variant->id} +{$item->quantity} do hủy Order ID {$order->id}.");
                } else {
                    Log::warning("Không tìm thấy Variant ID {$item->product_variant_id} để hoàn kho khi hủy Order ID {$order->id}.");
                }
            }

            $order->status = 'cancelled';
            $order->cancelled_at = now();
            $order->note = ($order->note ? $order->note . "\n" : '') . 'Đơn hàng được hủy bởi khách hàng';
            $order->save();

            DB::commit();

            Log::info("Order ID {$order->id} cancelled successfully by User ID " . Auth::id());

            return redirect()->route('client.account.accountOrderDetail', $order->id)
                ->with('success', 'Đơn hàng đã được hủy thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi khi hủy Order ID {$order->id} bởi User ID " . Auth::id() . ": " . $e->getMessage());
            return redirect()->route('client.account.accountOrderDetail', $order->id)
                ->with('error', 'Đã xảy ra lỗi khi hủy đơn hàng. Vui lòng thử lại.');
        }
    }

}
