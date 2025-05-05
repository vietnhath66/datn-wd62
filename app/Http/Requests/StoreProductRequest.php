<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric|min:0.01',
            'brand_id' => 'required|',
            'product_catalogue_id' => 'required|not_in:0',


        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                     => 'Bạn chưa nhập vào ô tên sản phẩm',
            'price.required'                    => 'Bạn chưa nhập vào ô tên sản phẩm',
            'price.numeric'                     => 'Giá sản phẩm phải là một số',
            'price.min'                         => 'Giá sản phẩm phải lớn hơn 0',
            'brand_id.required'                 => 'Bạn chưa chọn ô thương hiệu',
            'product_catalogue_id.not_in'       => 'Bạn chưa chọn ô danh mục sản phẩm',
        ];
    }
}
