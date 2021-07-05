<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TermLoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'amount' => $this->amount,
            'loan_term' => $this->loan_term,
            'repayment_freequency' => $this->repayment_freequency,
            'ref_no' => $this->ref_no,
            'status' => $this->status,
            'amount_to_repay' => $this->amount_to_repay,
            // 'term_amount_to_pay' => $this->term_amount_to_pay,
            'repayments' => new TermLoanRepaymentCollection($this->repayments)
        ];
    }
}
