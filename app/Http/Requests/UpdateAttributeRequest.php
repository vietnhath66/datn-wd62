<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Đặt true nếu không dùng quyền
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            // thêm các rules khác nếu cần
        ];
    }
}

