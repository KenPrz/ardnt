<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UserSocialsRule;

class UserSocialsRequest extends FormRequest
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
            'website' => ['nullable', 'string','max:255', 'url'],
            'twitter' => ['nullable', 'string', new UserSocialsRule,'max:255'],
            'instagram' => ['nullable', 'string', new UserSocialsRule,'max:255'],
            'facebook' => ['nullable', 'string', new UserSocialsRule,'max:255'],
            'linkedin' => ['nullable', 'string', new UserSocialsRule,'max:255'],
            'medium' => ['nullable', 'string', new UserSocialsRule,'max:255'],
        ];
    }
}
