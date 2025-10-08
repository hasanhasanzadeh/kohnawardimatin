<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class PageUpdateRequest extends FormRequest
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
            'title'=>'required|string|max:256|unique:pages,title,'.$this->id,
            'slug'=>'required|string|max:256|unique:pages,slug,'.$this->id,
            'status'=>'required|in:1,0',
            'image'=>['nullable',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'description'=>'required|string',
            'page_cat_id'=>'required|exists:page_cats,id',
            'meta_title'=>'required|string|max:256',
            'meta_keywords'=>'required|string',
            'meta_description'=>'required|string',
        ];
    }
}
