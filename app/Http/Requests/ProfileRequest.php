<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ProfileRequest extends FormRequest
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
            'full_name'=>'nullable|max:255|string',
            'gender'=>'required|in:male,female',
            'birthday'=>'nullable|date',
            'mail'=>'nullable|mail|unique:users,mail,'.$this->id,
            'mobile'=>'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|digits:11|unique:users,mobile,'.$this->id,
            'national_code'=>'nullable|numeric|digits:10',
            'card_number'=>'nullable|numeric|digits:16',
            'image'=>['nullable',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'news_letter'=>'nullable|in:0,1'
        ];
    }
}
