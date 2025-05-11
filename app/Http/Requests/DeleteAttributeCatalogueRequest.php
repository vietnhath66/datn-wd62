<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAttributeCatalogueRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Cho phép người dùng thực hiện thao tác xoá
        // Nếu bạn có quyền phức tạp hơn, kiểm tra tại đây
        return true;
    }

    public function rules(): array
    {
        // Xoá thường không cần validate field nào cả
        return [];
    }
}
