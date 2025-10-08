<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'slug'=>'required|string|max:256|unique:posts,slug,'.$this->id,
            'description'=>'required|string',
            'price'=>'required|numeric',
            'url'=>'required|url',
            'status'=>'required|in:0,1',
            'payment_state'=>'nullable|in:0,1',
        ];
    }
}
