<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class SettingUpdateRequest extends FormRequest
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
            'title'=>'required|string|max:256|unique:settings,title,'.$this->id,
            'about'=>'required|string',
            'product_text'=>'nullable|string',
            'copy_right'=>'required|string',
            'free_post'=>'nullable|numeric',
            'url'=>'required|string',
            'email'=>'required|email|max:150',
            'text_chat'=>'nullable|string|max:1500',
            'tel'=>'required|string|max:50',
            'favicon'=>['nullable',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'logo'=>['nullable',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)],
            'instagram'=>'required|url|max:150',
            'telegram'=>'nullable|url|max:150',
            'facebook'=>'nullable|url|max:150',
            'x_link'=>'nullable|url|max:150',
            'whatsapp'=>'nullable|url|max:150',
            'youtube'=>'nullable|url|max:150',
            'linkedin'=>'nullable|url|max:150',
            'address'=>'required|string',
            'meta_title'=>'required|string|max:256',
            'meta_keywords'=>'required|string',
            'meta_description'=>'required|string',
        ];
    }
}
