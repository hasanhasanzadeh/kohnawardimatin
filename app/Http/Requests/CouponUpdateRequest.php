<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CouponUpdateRequest extends FormRequest
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
            'title'=>'required|max:256|string',
            'slug'=>'required|string|max:256|unique:articles,slug,'.$this->id,
            'code'=>'required|string|unique:coupons,code,'.$this->id,
            'discount'=>'required|numeric|min:0|max:100',
            'expired_at'=>'required|date_format:Y-m-d',
            'description'=>'required|string|max:400',
            'status'=>'required|in:0,1',
            'image'=>['nullable',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'meta_title'=>'required|string|max:256',
            'meta_keywords'=>'required|string',
            'meta_description'=>'required|string',
        ];
    }
}
