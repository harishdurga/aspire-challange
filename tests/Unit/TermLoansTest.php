<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TermLoansTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_term_loan_model_with_given_data_is_created()
    {
        $user = User::factory()->create();
        $loan = \App\Models\TermLoan::create([
            'ref_no' => '12345678',
            'user_id' => $user->id,
            'amount' => 150000,
            'loan_term' => 10,
            'repayment_freequency' => 'weekly'
        ]);
        $loan = \App\Models\TermLoan::where('ref_no', '12345678')->first();
        $this->assertEquals('12345678', $loan->ref_no);
        $this->assertEquals(150000, $loan->amount);
        $this->assertEquals(10, $loan->loan_term);
    }
}
