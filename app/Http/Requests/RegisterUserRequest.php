<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\UserHandleRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterUserRequest extends FormRequest
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'handle' => [
                'required',
                'string',
                'max:30',
                'min:5',
                new UserHandleRule,
                'unique:users,handle',
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'handle.required' => 'The handle field is required.',
            'handle.string' => 'The handle must be a string.',
            'handle.max' => 'The handle may not be greater than 30 characters.',
            'handle.unique' => 'The handle has already been taken.',
        ];
    }
}
