<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class PostStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255|min:5',
            'content' => 'required',
            'author_id' => 'required',
            'feature_image' => ['nullable', File::image()->min('5mb')],
            'categories' => ['required', 'array', 'min:1'],
            'tags' => ['required', 'array', 'min:1']
        ];
    }
}
