<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(ForgotPasswordRequest $request)
    {
        try {
            $status = Password::sendResetLink($request->only('email'));
        } catch (\Throwable $e) {
            Log::error('Password email error', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Failed to send email'], 500);
        }

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)], Response::HTTP_OK);
        }

        Log::error('Password reset link failed', [
            'email' => $request->email,
            'status' => $status,
        ]);

        return response()->json(['message' => __($status)], Response::HTTP_BAD_REQUEST);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['message' => __($status)], Response::HTTP_OK);
        }

        Log::error('Password reset failed', [
            'email' => $request->email,
            'status' => $status,
        ]);

        return response()->json(['message' => __($status)], Response::HTTP_BAD_REQUEST);
    }
}
