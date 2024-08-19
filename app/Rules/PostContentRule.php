<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PostContentRule implements ValidationRule
{
    /**
     * Run the validation rule.
     * This Rule is used to validate the content of a post. since we use tiptap editor,
     * we need to make sure that the content is not empty,
     * has at least 5 characters, does not exceed 140 characters,
     * and is valid HTML.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove all HTML tags from the content
        $plainText = strip_tags($value);
        if (strlen($plainText) < 5) {
            $fail('The :attribute must contain at least 5 characters.');
        }
        // Check if the content without HTML tags has exactly 140 characters
        if (strlen($plainText) > 140) {
            $fail('The :attribute must not exceed 140 characters.');
        }

        // Optionally, check if the input is valid HTML
        if ($plainText === $value) {
            $fail('The :attribute must contain valid HTML content.');
        } 
    }
}
