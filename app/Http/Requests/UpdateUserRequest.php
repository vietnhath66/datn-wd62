<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // hoặc kiểm tra quyền tùy bạn
    }

    public function rules(): array
    {
        return [
            // Viết các rule validation tại đây
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $this->user->id,

        ];
    }
}
