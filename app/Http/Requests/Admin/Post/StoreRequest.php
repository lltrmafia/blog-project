<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required', 'string', 'max:255',
            'excerpt' => 'nullable', 'string', 'max:500',
            'content' => 'required', 'string',
            'category_id' => 'nullable', 'exists:categories,id',
            'image' => 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048',
            'action' => 'nullable|string|in:draft,publish',
        ];
    }
}
