<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueIfNotVerified implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the email exists in the database
        $user = User::where('email', $value)->first();

        // If user exists and is verified, fail the validation
        if ($user && $user->email_verified_at) {
            $fail('The :attribute has already been taken by a verified account.');
        }
    }
}
