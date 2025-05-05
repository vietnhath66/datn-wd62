<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct() {}

    public function index()
    {   
        if(Auth::id() > 0){
            return redirect()->route('admin.dashboard.index');
        }

        return view('admin.auth.login');
    }

    public function login(AuthRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
    
        // Tìm user theo email
        $user = \App\Models\User::where('email', $request->email)->first();
    
        if ($user) {
            // Kiểm tra nếu tài khoản đã bị khoá (status = 0)
            if ($user->status == 0) {
                return redirect()->route('auth.admin')->with('error', 'Tài khoản của bạn đã bị khóa.');
            }
    
            // Tiến hành đăng nhập
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard.index')->with('success', 'Đăng nhập thành công');
            }
        }
    
        return redirect()->route('auth.admin')->with('error', 'Email hoặc mật khẩu không chính xác');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect()->route('auth.admin');
    }
}
