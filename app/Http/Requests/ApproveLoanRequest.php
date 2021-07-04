<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationJsonResponse;

class ApproveLoanRequest extends FormRequest
{
    use FailedValidationJsonResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->tokenCan('loan:aprrove');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ref_no' => 'required|exists:term_loans',
            'status' => 'required|in:approved,rejected'
        ];
    }
}
