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
            'banner.required' => 'Please select an image',
            'banner.image' => 'File must be an image',
            'banner.mimes' => 'Only png,jpg,jpeg files are allowed',
            'banner.max' => 'Maximum allowed file size is 2MB',
        ];
    }
}
