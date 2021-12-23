<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\CorporateCodeVerify;
class StorePrimaryAccount extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'pmaId' => [],
            'firstName' => ['required', 'max:30'],
            'lastName' => ['required', 'max:30'],
            'email' => ['email', 'required', Rule::unique('primary_accs')],
            'password' => ['required'],
            'aedAsignType' => ['required', new CorporateCodeVerify()],
            //
        ];
    }

    public function messages()
    {
        return [
            'firstName.required' => 'First Name is required',
            'firstName.max' => 'First Name is too long',
            'lastname.required' => 'Last Name is required',
            'lastname.max' => 'Last Name is too long',
            'email.required' => 'Email is required',
            'email.email' => 'Email invalid',
            'aedAsignType.required' => 'This field is required(AED Type)',
            'aedAsignType.numeric' => 'This field has to be numeric(AED Type)',

        ];
    }
}
