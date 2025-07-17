<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthRepository implements \App\Interfaces\JWTAuthRepositoryInterface
{
    public function register(array $data)
    {
        $user = User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]
        );

        $token = JWTAuth::fromUser($user);

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        Log::info('Login attempt by email: ' . $credentials['email']);
        if (! $token = JWTAuth::attempt($credentials)) {
            Log::warning('Login failed for email: ' . $credentials['email']);

            return false;
        }
        Log::info('Login success for: ' . $credentials['email']);

        return $token;
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function getUserInfo()
    {
        return Auth::user();
    }
}
