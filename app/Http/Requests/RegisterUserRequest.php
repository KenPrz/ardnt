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
        $user = User::withTrashed()
            ->where('email', $this->email)->first();

        if ($user && $this->handleExpiredVerification($user)) {
            $user = null;
        }
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
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

    private function handleExpiredVerification($user): bool
    {
        if ($user->email_verified_at) {
            return false; // User is already verified, no need to delete.
        }

        if ($user->created_at->diffInMinutes() > 1) {
            $user->forceDelete();
            return true; // Indicate that the user was deleted.
        }

        return false; // User was not deleted and is still unverified.
    }
}
