<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name!',
            'name.min' => 'Please enter at least 2 characters.',
            'email.required' => 'Please fill in your email!',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'Email already exists.',
            'password.required' => 'Please fill in your password!',
            'password.min' => 'Please enter at least 6 characters.',
            'password.confirmed' => 'Confirm password does not match.',
        ];
    }
}
