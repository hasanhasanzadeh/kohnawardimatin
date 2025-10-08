<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'full_name'=>'required|string|max:100',
            'receptor_name'=>'required|string|max:100',
            'receptor_mobile'=>'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
            'city_id'=>'required|exists:cities,id',
            'post_code'=>'required|digits:10|numeric',
            'national_code'=>'required|ir_national_id',
            'address'=>'required|string|max:150',
        ];
    }
}
