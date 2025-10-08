<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class BrandRequest extends FormRequest
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
            'title'=>'required|string|max:255|unique:brands,title',
            'slug'=>'required|string|max:256|unique:brands,slug',
            'description'=>'nullable|string',
            'brand_url'=>'nullable|url',
            'image'=>['required',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'meta_title'=>'nullable|string|max:255',
            'meta_keywords'=>'nullable|string',
            'meta_description'=>'nullable|string',
        ];
    }
}
