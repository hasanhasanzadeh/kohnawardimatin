<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'=>'required|max:255|string',
            'slug'=>'required|string|max:256|unique:articles,slug',
            'body'=>'required|string|max:4294967295',
            'description'=>'required|string|max:65535',
            'publish_date'=>'nullable|date_format:Y-m-d',
            'status'=>'required|in:0,1',
            'image'=>['required',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'meta_title'=>'required|string|max:255',
            'meta_keywords'=>'required|string|max:65535',
            'meta_description'=>'required|string|max:65535',
        ];
    }
}
