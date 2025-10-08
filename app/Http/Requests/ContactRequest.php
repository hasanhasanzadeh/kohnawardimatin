<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'=>'required|string|max:50',
            'mail'=>'nullable|email|max:150',
            'mobile'=>'required|string|max:11',
            'subject'=>'required|string|max:50',
            'message'=>'required|string|max:500',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
}
