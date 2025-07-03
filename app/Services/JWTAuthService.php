<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Interfaces\JWTAuthRepositoryInterface;

class JWTAuthService
{
    protected $authRepo;

    public function __construct(JWTAuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function registerUser(array $data)
    {
        return $this->authRepo->register($data);
    }

    public function loginUser(array $credentials)
    {
        $token = $this->authRepo->login($credentials);
        if (!$token) {
            Log::error('AuthService: Login failed.');
        } else {
            Log::info('AuthService: Token issued.');
        }
        return $token;
    }

    public function logoutUser()
    {
        return $this->authRepo->logout();
    }

    public function getUserDetails()
    {
        return $this->authRepo->getUserInfo();
    }
}
