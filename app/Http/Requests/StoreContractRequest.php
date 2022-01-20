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
            'contractId' => [],
            'locationAccLocationId' => ['required'],
            'servicesCatalogCorpId' => ['required'],
            'fullName' => ['required'],
            'terms' => ['required'],
            'description' => [],
            'amount' => ['required'],
            'numMonth' => ['required'],
            'numPayments' => ['required'],
            'contractBody' => ['required'],
            'startDate' => ['required'],
            'endDate' => ['required'],
            'status' => ['required'],
            'signature' => ['required'],
            'freeMonths' => [''],
            'frequency' => [''],
            'grossAmount' => [''],
            'totalContract' => [''],
            'netContract' => [''],
            'netAmount' => [''],
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
