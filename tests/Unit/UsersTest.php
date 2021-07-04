<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_user_model_is_created()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@email.com',
            'password' => 'Test@2022'
        ]);
        $userFromDB = User::where('email', 'johndoe@email.com')->first();
        $this->assertEquals($user->email, $userFromDB->email);
    }
}
