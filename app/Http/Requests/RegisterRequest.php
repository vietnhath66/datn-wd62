<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép request chạy
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s]+$/u'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => ['nullable', 'integer', 'exists:roles,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ và tên không được để trống!',
            'name.regex' => 'Họ và tên chỉ được chứa chữ cái!',
            'email.required' => 'Email là bắt buộc!',
            'email.email' => 'Email không hợp lệ!',
            'email.unique' => 'Email này đã được sử dụng!',
            'password.required' => 'Mật khẩu không được để trống!',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp!',
            'role_id.exists' => 'Role không hợp lệ!',
        ];
    }
}
