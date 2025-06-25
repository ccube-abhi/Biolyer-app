<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Services\JWTAuthService;

class JWTAuthController extends Controller
{
    protected $authService;

    public function __construct(JWTAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {   
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);
        $user = $this->authService->registerUser($request->all());
        return response()->json($user, 201);
    }

    public function login(Request $request)
    {
        $token = $this->authService->loginUser($request->only('email', 'password'));
        return $token
            ? response()->json(['status' => true,'token' => $token])
            : response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout()
    {
        $this->authService->logoutUser();
        return response()->json(['status' => true,'message' => 'User logged out']);
    }

    public function me()
    {
        return response()->json(['status' => true,"user" =>$this->authService->getUserDetails()]);
    }
}
