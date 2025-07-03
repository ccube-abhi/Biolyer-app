<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Services\JWTAuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class JWTAuthController extends Controller
{
    protected $authService;
    // Traits
    use ApiResponse;

    public function __construct(JWTAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validate = $request->validated();
            $user = $this->authService->registerUser($request->safeParam());

            return $this->successResponse(__('messages.register_success'), $user, Response::HTTP_CREATED);
        } catch (Throwable $e) {
            Log::error('Register Error: ' . $e->getMessage(), ['exception' => $e]);
            return $this->errorResponse(__('messages.server_error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $validate = $request->validated();
            $token = $this->authService->loginUser($request->safeParam());

            return $token
                ? $this->successResponse(__('messages.login_success'), ['token' => $token])
                : $this->errorResponse(__('messages.login_error'), Response::HTTP_UNAUTHORIZED);
        } catch (Throwable $e) {
            Log::error('Login Error: ' . $e->getMessage(), ['exception' => $e]);
            return $this->errorResponse(__('messages.server_error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout()
    {
        try {
            $this->authService->logoutUser();
            return $this->successResponse(__('messages.logout_success'), Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error('Logout Error: ' . $e->getMessage(), ['exception' => $e]);
            return $this->errorResponse(__('messages.server_error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function me()
    {
        try {
            $user = $this->authService->getUserDetails();
            return $this->successResponse(__('messages.login_success'), $user, Response::HTTP_OK);
        } catch (Throwable $e) {
            Log::error('Get User Info Error: ' . $e->getMessage(), ['exception' => $e]);
            return $this->errorResponse(__('messages.server_error'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
