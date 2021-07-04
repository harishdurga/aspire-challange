<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermLoanRepayment extends Model
{
    use HasFactory;
    protected $fillable = ['ref_no', 'amount', 'term_loan_id'];

    public function term_loan()
    {
        return $this->belongsTo(TermLoan::class);
    }
}
