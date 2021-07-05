<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermLoan extends Model
{
    use HasFactory;
    protected $fillable = ['ref_no', 'user_id', 'amount', 'loan_term', 'repayment_freequency', 'status', 'interest_rate'];

    public function getStatusAttribute($value)
    {
        $status_to_string = [0 => 'pending', 1 => 'approved', -1 => 'rejected'];
        return $status_to_string[$value] ?? null;
    }

    public function setStatusAttribute($value)
    {
        $string_to_status = ['pending' => 0,  'approved' => 1, 'rejected' => -1];
        $this->attributes['status'] = $string_to_status[$value] ?? 0;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function repayments()
    {
        return $this->hasMany(TermLoanRepayment::class);
    }

    public function getAmountToRepayAttribute()
    {
        $amountPaid = $this->repayments()->sum('amount');
        return $this->amount - $amountPaid;
    }

    // public function getTermAmountToPayAttribute()
    // {
    //     $amountPaid = $this->repayments()->sum('amount');
    //     return (($this->amount - $amountPaid) * ($this->interest_rate / $this->loan_term) * (1 + ($this->interest_rate / $this->loan_term)) * $this->loan_term) / ((1 + ($this->interest_rate / $this->loan_term)) * $this->loan_term) - 1;
    // }


}
