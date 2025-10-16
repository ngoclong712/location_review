<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống',
            'avatar.image' => 'Ảnh đại diện phải là file hình ảnh',
            'avatar.mimes' => 'Ảnh đại diện chỉ hỗ trợ định dạng JPG, JPEG, PNG',
            'avatar.max' => 'Kích thước ảnh tối đa là 2MB',
        ];
    }
}
