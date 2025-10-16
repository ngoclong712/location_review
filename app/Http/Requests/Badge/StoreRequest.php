<?php

namespace App\Http\Requests\Badge;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'description' => 'nullable|string|max:1000',
            'badge' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // file upload
        ];
    }

    /**
     * Get the custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The badge name is required.',
            'name.string' => 'The badge name must be a string.',
            'name.max' => 'The badge name may not exceed 255 characters.',

            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not exceed 1000 characters.',

            'badge.required' => 'The badge image file is required.',
            'badge.image' => 'The uploaded file must be an image.',
            'badge.mimes' => 'The badge image must be a file of type: jpg, jpeg, png, or webp.',
            'badge.max' => 'The badge image size may not exceed 2MB.',
        ];
    }
}
