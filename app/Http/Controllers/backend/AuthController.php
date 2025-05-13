<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        if (Auth::id() > 0) {
            return redirect()->route('admin.dashboard.index');
        }
        
        return view('admin.auth.login');
    }

public function login(AuthRequest $request)
{
    $user = User::where('email', $request->email)->first();

    // Kiểm tra nếu người dùng không tồn tại
    if (!$user) {
        return redirect()->route('auth.admin')->with('error', 'Email hoặc mật khẩu không chính xác');
    }
    
    // Kiểm tra nếu tài khoản bị khóa
    if ($user->is_locked) { // Đã bị khóa nếu is_locked = true (hoặc 1)
        return redirect()->route('auth.admin')->with('error', 'Tài khoản của bạn đã bị khóa');
    }
    // Kiểm tra vai trò của người dùng
    if ($user->role_id == 1) {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];  

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard.index')->with('success', 'Đăng nhập thành công');
        } else {
            return redirect()->route('auth.admin')->with('error', 'Email hoặc mật khẩu không chính xác');
        }
    } else {
        return redirect()->route('auth.admin')->with('error', 'Đăng nhập thất bại, có thể đây không phải tài khoản Admin');
    }
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.admin');
    }
}
