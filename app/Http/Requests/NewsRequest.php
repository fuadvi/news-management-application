<?php

namespace App\Http\Requests;

use AllowDynamicProperties;
use Illuminate\Foundation\Http\FormRequest;

#[AllowDynamicProperties] class NewsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'content' => ['required','string'],
            'images' => ['required','image','mimes:jpeg,png,jpg','max:2048'],
            'category_id' => ['required','exists:categories,id'],
            'user_id' => ['required','exists:users,id'],
        ];
    }
}
