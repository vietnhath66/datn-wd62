<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Mail\VerifyUserEmail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeAuthController extends Controller
{


    public function viewLogin()
    {
        return view('client.auth.auth');
    }


public function postLogin(Request $request)
{
    $request->validate([
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ], [
        'email.required' => 'Vui lòng nhập địa chỉ email.',
        'email.email' => 'Địa chỉ email không hợp lệ.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
    ]);

    if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    $user = Auth::user();

    if ($user && (int)$user->is_locked === 1) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.viewLogin')->withErrors([
            'email' => 'Tài khoản của bạn đã bị khóa.',
        ])->withInput($request->only('email'));
    }

    if ($user && $user->email_verified_at === null) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.viewLogin')->withErrors([
            'email' => 'Tài khoản của bạn chưa được xác thực email. Vui lòng kiểm tra hộp thư đến để xác thực.',
        ])->withInput($request->only('email'));
    }

    return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Đăng nhập thành công!');
}



    public function postRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', \Illuminate\Validation\Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone ?? '',
            'role_id' => 5,
            'status' => '0',
            'email_verified_at' => null,
        ]);

        try {
            Mail::to($user->email)->send(new VerifyUserEmail($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send verification email to " . $user->email . ": " . $e->getMessage());
        }



        return redirect()->route('client.viewConfirmPass');
    }


    public function verifyEmail(Request $request, $id, $hash): RedirectResponse
    {
        $user = User::find($id);

        if (!$user || !hash_equals((string) $hash, sha1((string) $user->getEmailForVerification()))) {
            return redirect()->route('client.viewLogin')->with('error', 'Link xác thực không hợp lệ.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('client.viewLogin')->with('status', 'Email của bạn đã được xác thực.');
        }

        if ($user->markEmailAsVerified()) {
            $user->status = '1';
            $user->save();

            event(new Verified($user));
        }

        return redirect()->route('client.viewLogin')->with('success', 'Email của bạn đã được xác thực thành công! Bây giờ bạn có thể đăng nhập.');
    }


    public function viewConfirmPass()
    {
        return view('client.auth.confirm-mail');
    }


    public function viewForgot()
    {
        return view('client.auth.forgot-password');
    }


    public function resetMail(Request $request) // Ví dụ đặt tên hàm là sendResetLinkEmail
    {
        // Phương thức sendResetLink được cung cấp bởi trait SendsPasswordResetEmails.
        // Nó sẽ validate email, tạo token, gửi mail, và trả về redirect response.
        $response = $this->sendResetLink($request); // Gọi phương thức non-static từ trait


        // Xử lý response trả về từ trait
        if ($response == \Illuminate\Auth\Passwords\PasswordBroker::RESET_LINK_SENT) {
            // Email đã được gửi thành công
            return back()->with('status', trans($response));
            // Hoặc chuyển hướng về trang login/forgot với thông báo tùy chỉnh
            // return redirect()->route('client.viewForgot')->with('success', 'Link đặt lại mật khẩu đã được gửi. Vui lòng kiểm tra email của bạn.');
        } else {
            // Gửi email thất bại
            return back()->withErrors(['email' => trans($response)]);
            // Hoặc chuyển hướng về trang login/forgot với thông báo lỗi tùy chỉnh
            // return redirect()->route('client.viewForgot')->with('error', 'Không thể gửi link đặt lại mật khẩu. Vui lòng kiểm tra địa chỉ email hoặc thử lại sau.');
        }
    }


    public function postChangePass()
    {
        return view('client.auth.change-password');
    }


    public function viewWishlists()
    {
        $user = Auth::user();

        $wishlistProducts = $user->wishlistedProducts()
            ->with(['variants'])
            ->where('publish', 1)
            ->orderBy('wishlists.created_at', 'desc')
            ->paginate(12);

        return view('client.wishlists.wishlists')->with([
            'wishlistProducts' => $wishlistProducts
        ]);
    }


    public function addWishlists(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id', // Kiểm tra product_id tồn tại trong bảng products
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422); // Unprocessable Entity
        }

        $userId = Auth::id();
        $productId = $request->input('product_id');

        try {
            // Kiểm tra xem đã tồn tại chưa (dùng firstOrCreate để ngắn gọn)
            // firstOrCreate sẽ tìm bản ghi khớp, nếu không thấy sẽ tạo mới
            $wishlistItem = Wishlist::firstOrCreate(
                [
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]
                // Không cần tham số thứ 2 nếu chỉ cần tạo với 2 cột này
            );

            // Kiểm tra xem bản ghi có vừa được tạo hay không (wasRecentlyCreated là thuộc tính của Eloquent)
            if ($wishlistItem->wasRecentlyCreated) {
                Log::info("User {$userId} added Product {$productId} to wishlist.");
                return response()->json(['success' => true, 'message' => 'Đã thêm vào danh sách yêu thích!']);
            } else {
                Log::info("User {$userId} tried to add Product {$productId} which is already in wishlist.");
                // Có thể trả về success=true vì sản phẩm vẫn nằm trong wishlist
                return response()->json(['success' => true, 'message' => 'Sản phẩm đã có trong danh sách yêu thích.']);
                // Hoặc trả về lỗi nhẹ nếu muốn thông báo rõ là đã có sẵn
                // return response()->json(['success' => false, 'message' => 'Sản phẩm đã có trong danh sách yêu thích.'], 409); // Conflict
            }

        } catch (\Exception $e) {
            Log::error("Error adding product to wishlist: User {$userId}, Product {$productId}. Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi, vui lòng thử lại.'], 500); // Internal Server Error
        }
    }


    public function removeWishlist(Product $product)
    {
        $user = Auth::user(); // Lấy người dùng đang đăng nhập

        if (!$user) {
            // Trường hợp hiếm gặp nhưng nên kiểm tra
            return redirect()->route('client.viewWishlists')->with('error', 'Vui lòng đăng nhập lại.');
        }

        try {
            // Sử dụng relationship belongsToMany (wishlistedProducts) đã định nghĩa trong User model
            // Phương thức detach() sẽ xóa bản ghi tương ứng trong bảng trung gian (wishlists)
            $deleted = $user->wishlistedProducts()->detach($product->id);

            if ($deleted) {
                // Nếu có bản ghi bị xóa (tức là sản phẩm có trong wishlist và đã được xóa)
                Log::info("User {$user->id} removed Product {$product->id} from wishlist.");
                return redirect()->route('client.viewWishlists')->with('success', 'Đã xóa "' . $product->name . '" khỏi danh sách yêu thích.');
            } else {
                // Nếu không có bản ghi nào bị xóa (có thể sản phẩm không có trong wishlist của user này)
                Log::warning("User {$user->id} tried to remove Product {$product->id} which was not in their wishlist.");
                return redirect()->route('client.viewWishlists')->with('info', 'Sản phẩm không có trong danh sách yêu thích của bạn.');
            }

        } catch (\Exception $e) {
            Log::error("Error removing product from wishlist: User {$user->id}, Product {$product->id}. Error: " . $e->getMessage());
            return redirect()->route('client.viewWishlists')->with('error', 'Đã xảy ra lỗi khi xóa sản phẩm khỏi danh sách yêu thích.');
        }
    }
}

