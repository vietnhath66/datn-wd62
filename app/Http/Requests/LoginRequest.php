<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Xác thực người dùng có quyền sử dụng request này.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Các quy tắc xác thực cho request này.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'], // Kiểm tra email tồn tại trong cơ sở dữ liệu
            'password' => ['required', 'min:8'], // Mật khẩu yêu cầu tối thiểu 8 ký tự
        ];
    }

    /**
     * Các thông báo lỗi tùy chỉnh.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập email!',
            'email.email' => 'Email không hợp lệ!',
            'email.exists' => 'Email chưa được đăng ký!',
            'password.required' => 'Mật khẩu không được để trống!',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự!',
        ];
    }

    /**
     * Xác thực người dùng và xử lý giới hạn lượt đăng nhập.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        // Đảm bảo người dùng không vượt quá giới hạn đăng nhập
        $this->ensureIsNotRateLimited();

        // Thực hiện xác thực người dùng với email và mật khẩu
        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'), // Thông báo nếu email hoặc mật khẩu sai
            ]);
        }

        RateLimiter::clear($this->throttleKey()); // Xóa bộ đếm khi đăng nhập thành công
    }

    /**
     * Kiểm tra xem có vượt quá số lần đăng nhập cho phép không.
     *
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            event(new Lockout($this)); // Gửi sự kiện khi bị khóa tài khoản vì đăng nhập sai quá nhiều

            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => RateLimiter::availableIn($this->throttleKey()) // Thông báo cho người dùng biết khi nào họ có thể thử lại
                ]),
            ]);
        }
    }

    /**
     * Tạo khóa throttle duy nhất cho mỗi email và địa chỉ IP.
     *
     * @return string
     */
    public function throttleKey()
    {
        return strtolower($this->input('email')) . '|' . $this->ip(); // Khóa throttle kết hợp email và IP người dùng
    }
}
