<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeCatalogueRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Cho phép tất cả hoặc thêm kiểm tra phân quyền tại đây
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            // Thêm rule khác nếu cần
        ];
    }
}
