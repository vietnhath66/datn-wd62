<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')],
            'permission_ids' => 'required|array|min:1', 
            'permission_ids.*' => 'required|integer|exists:custom_permissions,id' 
        ];

    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên vai trò không được để trống.',
            'name.unique' => 'Tên vai trò này đã tồn tại.',
            'permission_ids.required' => 'Bạn phải chọn ít nhất một quyền cho vai trò này.',
            'permission_ids.min' => 'Bạn phải chọn ít nhất một quyền cho vai trò này.',
            'permission_ids.*.exists' => 'Quyền được chọn không hợp lệ.',
        ];
    }
}
