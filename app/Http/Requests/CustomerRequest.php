<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CustomerRequest extends FormRequest
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
            'mobile'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,mobile,'.$this->id,
            'full_name'=>'nullable|string|max:256',
            'image'=>['nullable',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'email'=>'nullable|email|unique:users,email,'.$this->id,
            'gender'=>'required|in:male,female',
            'birthday'=>'nullable|date',
            'status'=>'nullable|in:0,1',
        ];
    }
}
