<?php
namespace App\Traits;

trait ApiResponse
{
    public function successResponse($message, $data = [], $code = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public function errorResponse($message, $code = 400)
    {
        return response()->json([
            'status'  => 'false',
            'message' => $message,
        ], $code);
    }
}
