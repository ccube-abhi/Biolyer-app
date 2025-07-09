<?php

namespace Tests\Feature;

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
            'email' => 'test2@test.com',
            'password' => 'Test@th456'
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'name',
                    'email'
                ],
                'token'
            ],
            'message'
        ]);
    }

}
