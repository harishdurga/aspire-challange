<?php

namespace App\Http\Controllers\API;

use App\Models\TermLoan;
use Illuminate\Http\Request;
use App\Models\TermLoanRepayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\RepayLoanRequest;
use App\Http\Resources\TermLoanResource;
use App\Http\Requests\ApproveLoanRequest;
use App\Http\Requests\ApplyForLoanRequest;
use App\Http\Resources\TermLoanCollection;
use App\Http\Resources\TermLoanRepaymentResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoansController extends Controller
{
    public function applyForLoan(ApplyForLoanRequest $request)
    {
        return new TermLoanResource(TermLoan::create([
            'amount' => $request->amount,
            'loan_term' => $request->loan_term,
            'repayment_freequency' => $request->repayment_freequency,
            'user_id' => $request->user()->id,
            'ref_no' => $request->user()->id . '-' . time(),
            'status' => 0
        ]));
    }

    public function loanDetails($ref_no, Request $request)
    {
        $termLoan = TermLoan::where('ref_no', $ref_no)->with('repayments')->first();
        if ($termLoan) {
            if (!$request->user()->tokenCan('loan:details') && ($request->user()->id != $termLoan->user_id)) {
                abort(403);
            }
            return new TermLoanResource($termLoan);
        } else {
            throw new HttpResponseException(response()->json(['message' => 'No loan found with ref_no:' . $ref_no], 404));
        }
    }

    public function approveLoan(ApproveLoanRequest $request)
    {
        $termLoan = TermLoan::where('ref_no', $request->ref_no)->first();
        $termLoan->fill($request->validated())->save();
        return new TermLoanResource($termLoan);
    }

    public function getLoans(Request $request)
    {
        if (!$request->user()->tokenCan('loan:list')) {
            $termLoans = TermLoan::with('repayments')->paginate(10);
        } else {
            $termLoans = TermLoan::where('user_id', $request->user()->id)->with('repayments')->paginate(10);
        }
        return new TermLoanCollection($termLoans);
    }

    public function repayLoan(RepayLoanRequest $request)
    {
        $termLoan = TermLoan::where('ref_no', $request->ref_no)->first();
        if ($termLoan->status == 'approved') {
            $amountToPay = $termLoan->amount_to_repay;
            if ($request->amount <= $amountToPay) {
                $repayment = TermLoanRepayment::create([
                    'amount' => $request->amount,
                    'ref_no' => $termLoan->id . '-' . time(),
                    'term_loan_id' => $termLoan->id
                ]);
                return new TermLoanRepaymentResource($repayment);
            } else {
                return response()->json(['message' => 'Amount to repay for loan with ref_no: ' . $request->ref_no . ' is ' . $amountToPay], 400);
            }
        } else {
            return response()->json(['message' => 'loan with ref_no:' . $request->ref_no . ' is not approved yet.'], 400);
        }
    }
}
