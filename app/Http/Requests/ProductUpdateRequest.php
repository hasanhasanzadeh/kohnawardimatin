<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProductUpdateRequest extends FormRequest
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
//            'slug'=>'required|max:255|string|unique:products,slug,'.$this->id,
            'original_name'=>'nullable|max:255|string',
            'categories' => 'array|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'description'=>'nullable|string',
            'attribute'=>'nullable|string',
            'attributes'=>'nullable|array',
            'price'=>'required|numeric',
            'discount'=>'required|numeric',
            'special'=>'required|in:0,1',
            'expired_at'=>'nullable|date_format:Y-m-d',
            'buy_price'=>'required|numeric',
            'original_price'=>'required|numeric',
            'quantity'=>'required|numeric',
            'status'=>'nullable|in:active,inactive,soon',
            'image'=>['nullable',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'gallery'=>'nullable|array',
            'meta_title'=>'required|string|max:255',
            'meta_description'=>'required|string',
            'meta_keywords'=>'required|string',
        ];
    }
}
