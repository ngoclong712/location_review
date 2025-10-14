<?php

namespace App\Http\Requests\Config;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'banner' => [
                'required',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'banner.required' => 'Vui lòng chọn ảnh banner.',
            'banner.image' => 'Tệp phải là ảnh.',
            'banner.mimes' => 'Chỉ chấp nhận định dạng jpeg, png, jpg, gif.',
            'banner.max' => 'Kích thước ảnh tối đa là 2MB.',
        ];
    }
}
