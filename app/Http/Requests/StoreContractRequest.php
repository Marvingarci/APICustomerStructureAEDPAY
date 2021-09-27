<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
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
            'contractID' => [],
            'location_acc_locationID' => ['required'],
            'services_catalog_corpID' => ['required'],
            'fullName' => ['required'],
            'terms' => ['required'],
            'description' => ['required'],
            'amount' => ['required'],
            'num_month' => ['required'],
            'num_payments' => ['required'],
            'contract_body' => ['required'],
            'startDate' => ['required'],
            'endDate' => ['required'],
            'status' => ['required'],
            'signature' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'primary_acc_pmaId.required' => 'primary_pmaID is required',
            'fullName.required' => 'Full name is required',
            'ccn.required' => 'Credit Card Number is required',
            'exMonth.required' => 'Expiration month is required',
            'exYear.required' => 'Expiration year is required',
            'ccv.required' => 'CCV is required',
            'cardType.required' => 'Card type is required',
        ];
    }
}
