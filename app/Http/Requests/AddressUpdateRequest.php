<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'receptor_name'=>'required|string|max:100',
            'receptor_mobile'=>'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
            'city_id'=>'required|exists:cities,id',
            'post_code'=>'required|digits:10|numeric',
            'address'=>'required|string|max:150',
        ];
    }
}
