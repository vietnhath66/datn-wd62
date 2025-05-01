<?php

namespace App\Http\Controllers;

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
}
