<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'payId' => [],
            'primaryAccPmaId' => ['required'],
            'fullName' => ['required'],
            'ccn' => ['required'],
            'exMonth' => ['required'],
            'exYear' => ['required'],
            'ccv' => ['required'],
            'cardType' => ['required'],
            'address' => ['required'],
            'address2' => ['required'],
            'zip' => ['required'],
            'phone' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'locationsToAttachPrimary' => [],
            'locationsToAttachBackUp' => [],
        ];
    }

    public function messages()
    {
        return [
            'primaryAccPmaId.required' => 'primary_pmaId is required',
            'fullName.required' => 'Full name is required',
            'ccn.required' => 'Credit Card Number is required',
            'exMonth.required' => 'Expiration month is required',
            'exYear.required' => 'Expiration year is required',
            'ccv.required' => 'CCV is required',
            'cardType.required' => 'Card type is required',
        ];
    }
}
