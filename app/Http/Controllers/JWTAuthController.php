<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Services\JWTAuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
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
        $user = $this->authService->registerUser($request->validated());
        return $this->successResponse(__('messages.register_success'), $user, Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $token = $this->authService->loginUser($request->validated());
        return $token
            ? $this->successResponse(__('messages.login_success'), ['token' => $token])
            : $this->errorResponse(__('messages.login_error'), Response::HTTP_UNAUTHORIZED);
    }

    public function logout()
    {
        $this->authService->logoutUser();
        return $this->successResponse(__('messages.logout_success'), Response::HTTP_OK);
    }

    public function me()
    {   
        return $this->successResponse(__('messages.login_success'),$this->authService->getUserDetails(), Response::HTTP_OK);
    }
}
