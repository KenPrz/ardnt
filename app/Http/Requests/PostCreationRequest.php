<?php

namespace App\Http\Requests;

use App\Rules\PostContentRule;
use Illuminate\Foundation\Http\FormRequest;

class PostCreationRequest extends FormRequest
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
            'title' => $this->is_shared ? 'nullable|string|max:64|min:5' : 'required|string|max:64|min:5',
            'content' => ['required', 'string', 'max:5000', 'min:5', new PostContentRule],
            'theme' => 'nullable|numeric|exists:themes,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_public' => 'required|boolean',
            'is_shared' => 'required|boolean',
            'shared_post_id' => ['nullable', 'numeric', 'exists:posts,id'],
        ];

    }
}
