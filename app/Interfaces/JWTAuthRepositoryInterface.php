<?php

namespace App\Interfaces;

interface JWTAuthRepositoryInterface
{
    public function register(array $data);
    public function login(array $credentials);
    public function logout();
    public function getUserInfo();
}
