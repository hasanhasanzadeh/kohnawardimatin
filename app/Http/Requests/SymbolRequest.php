<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class SymbolRequest extends FormRequest
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
            'setting_id'=>'required|exists:settings,id',
            'title'=>'required|string|max:256|unique:symbols,title',
            'url'=>'required|url',
            'description'=>'nullable|string',
            'image'=>['required',File::types(['png', 'jpg','webp','jpeg','gif','svg','bmp','avif'])
                ->max(2 * 1024)]
        ];
    }
}
