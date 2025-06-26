<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Abhishek',
            'email' => 'userss@test.com',
            'password' => '123123'
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'name',
                'email',
            ],
            'message',
            'token' 
        ]);
    }

}
