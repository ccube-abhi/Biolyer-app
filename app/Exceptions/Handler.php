<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(
            function (Throwable $e) {
                //
            }
        );
    }

    public function render($request, Throwable $exception): JsonResponse
    {
        // ✅ Always force JSON response for API
        if ($request->expectsJson() || $request->is('api/*')) {
            config(['app.debug' => false]);
        }

        // 🛑 Validation errors
        if ($exception instanceof ValidationException) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $exception->errors(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            ); // 422
        }

        // 🔐 Unauthenticated
        if ($exception instanceof AuthenticationException) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Unauthenticated',
                ],
                Response::HTTP_UNAUTHORIZED
            ); // 401
        }

        // 🚫 Unauthorized access
        if ($exception instanceof AuthorizationException) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'You are not authorized to perform this action',
                ],
                Response::HTTP_FORBIDDEN
            ); // 403
        }

        // 🚫 Route not found
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'API route not found',
                ],
                Response::HTTP_NOT_FOUND
            ); // 404
        }

        // ❌ Model not found
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Resource not found',
                ],
                Response::HTTP_NOT_FOUND
            ); // 404
        }

        // ❌ Method not allowed
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'HTTP method not allowed',
                ],
                Response::HTTP_METHOD_NOT_ALLOWED
            ); // 405
        }

        // 🛑 Duplicate entry
        if ($exception instanceof UniqueConstraintViolationException) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Duplicate entry. Email or value already exists.',
                ],
                Response::HTTP_CONFLICT
            ); // 409
        }

        // ⚠️ Database errors
        if ($exception instanceof QueryException) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Database error occurred',
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            ); // 500
        }

        // 🚨 Fallback for unhandled exceptions
        return response()->json(
            [
                'status' => 'error',
                'message' => app()->isProduction()
                    ? 'Something went wrong'
                    : $exception->getMessage(),
            ],

            
            $exception instanceof HttpExceptionInterface
            ? $exception->getStatusCode()
            : \Symfony\Component\HttpFoundation\Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
