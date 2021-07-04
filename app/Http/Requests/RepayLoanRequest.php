<?php

namespace App\Http\Requests;

use App\Models\TermLoan;
use Illuminate\Foundation\Http\FormRequest;

class RepayLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TermLoan::where(['ref_no' => $this->ref_no, 'user_id' => $this->user()->id])->exists();
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
            'amount' => 'required|numeric|min:1'
        ];
    }
}
