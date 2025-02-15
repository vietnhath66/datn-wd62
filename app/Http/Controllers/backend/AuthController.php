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

        // dd($credentials,Auth::attempt($credentials));

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard.index')->with('success', 'Đăng nhập thành công');
        }else {
            return redirect()->route('auth.admin')->with('error', 'Email hoặc mật khẩu không chính xác');
        }

        // toastr()->error('Email hoặc mật khẩu không chính xác !');
 
        return redirect()->route('auth.admin')->with('error', 'Đăng nhập thất bại');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        
        $request->session()->regenerateToken();

        return redirect()->route('auth.admin');
    }
}
