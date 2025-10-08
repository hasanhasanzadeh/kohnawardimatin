<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class SettingRequest extends FormRequest
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
            'title'=>'required|string|max:256|unique:settings,title',
            'about'=>'required|string',
            'product_text'=>'nullable|string',
            'copy_right'=>'required|string',
            'free_post'=>'nullable|numeric',
            'url'=>'required|string',
            'mail'=>'required|mail|max:150',
            'tel'=>'required|string|max:50',
            'text_chat'=>'nullable|string|max:1500',
            'favicon'=>['required',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'logo'=>['required',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'address'=>'required|string',
            'instagram'=>'required|url|max:150',
            'telegram'=>'nullable|url|max:150',
            'facebook'=>'nullable|url|max:150',
            'x_link'=>'nullable|url|max:150',
            'whatsapp'=>'nullable|url|max:150',
            'youtube'=>'nullable|url|max:150',
            'linkedin'=>'nullable|url|max:150',
            'meta_title'=>'required|string|max:256',
            'meta_keywords'=>'required|string',
            'meta_description'=>'required|string',
        ];
    }
}
