<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLocation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'primaryAccPmaId' => [],
            'DID' => ['required', 'max:255'],
            'fullName' => ['required', 'max:255'],
            'username' => ['required', 'max:255', Rule::unique('location_accs')],
            'password' => ['required'],
            'locationName' => ['required'],
            'companyLegalName' => ['required'],
            'dbServer' => ['required'],
            'domain' => [],
            'locationShort' => [],
            'status' => [],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'username.required' => 'Username is required',
            //'firstName.max' => 'First Name is too long',
            'password.required' => 'Password is required',
            'locationName.required' => 'LocationName is required',
            'companyLegalName.required' => 'companyLegal',
            'dbServer.required' => 'dbServer',
            'locationDestination.required' => 'localDestination',

        ];
    }
}
