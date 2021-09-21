<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'primary_acc_pmaID' => [],
            'username' => ['required', 'max:30'],
            'password' => ['required'],
            'locationName' => ['required'],
            'companyLegalName' => ['required'],
            'dbDestination' => ['required'],
            'locationDestination' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            //'firstName.max' => 'First Name is too long',
            'password.required' => 'Password is required',
            'locationName.required' => 'LocationName is required',
            'companyLegalName.required' => 'companyLegal',
            'dbDestination.required' => 'dbDestination',
            'locationDestination.required' => 'localDestination',

        ];
    }
}
