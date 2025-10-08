<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CategoryRequest extends FormRequest
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
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:255',
            'slug'=>'required|string|max:256|unique:categories,slug,'.$this->id,
            'parent_id'=>'nullable|integer',
            'image'=>['nullable',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'meta_title'=>'required|string|max:255',
            'meta_keywords'=>'required|string',
            'meta_description'=>'required|string',
        ];
    }
}
