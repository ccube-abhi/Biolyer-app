<?php
namespace App\Services;

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
        return $this->authRepo->login($credentials);
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
