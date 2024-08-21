<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserSocialsRule implements ValidationRule
{
    /**
     * Check if the data input is a username.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $fail("Please only use your username.");
        } elseif (strpos($value, ' ') !== false) {
            $fail("Username cannot contain spaces.");
        }
    }
}
