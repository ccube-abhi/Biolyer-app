<?php

namespace Tests\Unit;

use App\Repositories\JWTAuthRepository;
use App\Services\JWTAuthService;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    public function test_user_can_register()
    {
        $input = [
            'name' => 'Abhishek',
            'email' => 'wertyu3456@gmail.com',
            'password' => 'Test@th456',
        ];

        $expectedOutput = [
            'user' => [
                'name' => 'Abhishek',
                'email' => 'wertyu3456@gmail.com',
            ],
            'token' => 'mocked.jwt.token',
        ];

        // Mock the repository
        $mockRepo = $this->createMock(JWTAuthRepository::class);
        $mockRepo->method('register')
            ->with($input)
            ->willReturn($expectedOutput);

        // Pass mocked repository to the service
        $service = new JWTAuthService($mockRepo);
        $result = $service->registerUser($input);

        // Assertions
        $this->assertEquals('Abhishek', $result['user']['name']);
        $this->assertEquals('wertyu3456@gmail.com', $result['user']['email']);
        $this->assertEquals('mocked.jwt.token', $result['token']);
    }
}
