<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_a_user_is_able_to_register()
    {
        $response = $this->post('/api/users/register', [
            'name' => 'John Doe',
            'email' => 'jondoe@test.com',
            'password' => 'Test@20222'
        ]);
        $response->assertStatus(201);
    }

    public function test_a_user_is_able_login()
    {
        $this->post('/api/users/register', [
            'name' => 'John Doe',
            'email' => 'jondoe@test.com',
            'password' => 'Test@20222'
        ]);
        $response = $this->post('/api/users/login', [
            'email' => 'jondoe@test.com',
            'password' => 'Test@20222'
        ]);
        $response->assertStatus(200);
    }
}
