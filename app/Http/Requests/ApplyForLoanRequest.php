<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationJsonResponse;

class ApplyForLoanRequest extends FormRequest
{
    use FailedValidationJsonResponse;
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
            'amount' => 'required|numeric|min:1',
            'loan_term' => 'required|numeric|min:1',
            'repayment_freequency' => 'required|in:daily,weekly,monthly'
        ];
    }
}
