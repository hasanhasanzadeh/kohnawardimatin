<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ArticleUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'=>'required|max:255|string',
            'slug'=>'required|string|max:256|unique:articles,slug,'.$this->id,
            'body'=>'required|string|max:4294967295',
            'description'=>'required|string|max:65535',
            'publish_date'=>'nullable|date_format:Y-m-d',
            'status'=>'required|in:0,1',
            'image'=>['nullable',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'meta_title'=>'required|string|max:255',
            'meta_keywords'=>'required|string|max:65535',
            'meta_description'=>'required|string|max:65535',
        ];
    }
}
