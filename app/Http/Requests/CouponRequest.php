<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CouponRequest extends FormRequest
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
            'title'=>'required|max:256|string',
            'code'=>'required|string|unique:coupons,code',
            'discount'=>'required|numeric|min:0|max:100',
            'expired_at'=>'required|date_format:Y-m-d',
            'slug'=>'required|string|max:256|unique:articles,slug',
            'description'=>'required|string|max:50048',
            'status'=>'required|in:0,1',
            'image'=>['required',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'meta_title'=>'required|string|max:256',
            'meta_keywords'=>'required|string',
            'meta_description'=>'required|string',
        ];
    }
}
