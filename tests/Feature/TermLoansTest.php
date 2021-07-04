<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TermLoansTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
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
    }
}
