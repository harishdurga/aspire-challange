<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TermLoansTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_is_able_to_apply_for_loan()
    {
        $user = User::factory()->create([
            'email' => 'jondoe@test.com',
            'password' => 'Test@20222',
            'name' => 'John Doe'
        ]);
        $token = $user->createToken('login-token')->plainTextToken;
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post('/api/loans/apply', [
            "amount" => 15000,
            "loan_term" => 7,
            "repayment_freequency" => "weekly"
        ]);
        $response->assertStatus(201);
        $this->assertNotNull($response['data']['ref_no']);
    }

    public function a_user_is_able_to_repay_loan()
    {
        //The first user in the database will the admin user
        $userOne = User::factory()->create([
            'email' => 'admin@admin.com',
            'password' => 'Test@20222',
            'name' => 'Admin'
        ]);
        $userTwo = User::factory()->create([
            'email' => 'johndoe@email.com',
            'password' => 'Test@20222',
            'name' => 'John Doe'
        ]);
        $userOneLoginResponse = $this->post('/api/users/login', [
            'email' => 'admin@admin.com',
            'password' => 'Test@20222'
        ]);
        $userTwoLoginResponse = $this->post('/api/users/login', [
            'email' => 'johndoe@email.com',
            'password' => 'Test@20222'
        ]);
        $loanApplyResponse = $this->withHeaders(['Authorization' => 'Bearer ' . $userTwoLoginResponse['token']])->post('/api/loans/apply', [
            "amount" => 15000,
            "loan_term" => 7,
            "repayment_freequency" => "weekly"
        ]);
        $loanApproveResponse = $this->withHeaders(['Authorization' => 'Bearer ' . $userOneLoginResponse['token']])->post('/api/loans/approve', [
            "ref_no" => $loanApplyResponse['data']['ref_no'],
            "status" => 'approved'
        ]);
        $loanRepaymentResponse = $this->withHeaders(['Authorization' => 'Bearer ' . $userTwoLoginResponse['token']])->post('/api/loans/repay', [
            "ref_no" => $loanApplyResponse['data']['ref_no'],
            "amount" => 1500
        ]);

        $loanRepaymentResponse->assertStatus(201);
        $this->assertNotNull($loanRepaymentResponse['data']['ref_no']);
    }

    public function test_a_user_cannot_repay_unapproved_loan()
    {

        $userTwo = User::factory()->create([
            'email' => 'johndoe@email.com',
            'password' => 'Test@20222',
            'name' => 'John Doe'
        ]);
        $userTwoLoginResponse = $this->post('/api/users/login', [
            'email' => 'johndoe@email.com',
            'password' => 'Test@20222'
        ]);
        $loanApplyResponse = $this->withHeaders(['Authorization' => 'Bearer ' . $userTwoLoginResponse['token']])->post('/api/loans/apply', [
            "amount" => 15000,
            "loan_term" => 7,
            "repayment_freequency" => "weekly"
        ]);
        $loanRepaymentResponse = $this->withHeaders(['Authorization' => 'Bearer ' . $userTwoLoginResponse['token']])->post('/api/loans/repay', [
            "ref_no" => $loanApplyResponse['data']['ref_no'],
            "amount" => 1500
        ]);

        $loanRepaymentResponse->assertStatus(400);
    }
}
