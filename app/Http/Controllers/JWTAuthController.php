<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\JWTAuthService;
use App\Http\Requests\RegisterRequest;
use App\Traits\ApiResponse;

class JWTAuthController extends Controller
{
    protected $authService;
    use ApiResponse;

    public function __construct(JWTAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    { 
        $user = $this->authService->registerUser($request->all());
        return $this->successResponse('User registered successfully.', $user, 201);
    }

    public function login(Request $request)
    {
        $token = $this->authService->loginUser($request->only('email', 'password'));
        return $token
            ? $this->successResponse('Login successful.', ['token' => $token])
            : $this->errorResponse('Invalid credentials', 401);
    }

    public function logout()
    {
        $this->authService->logoutUser();
        return $this->successResponse('User logged out', 201);
    }

    public function me()
    {   
        return $this->successResponse('User logged in',$this->authService->getUserDetails(), 201);
    }
}
