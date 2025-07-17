<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    //
    public function successResponse($message, $data = [], $code = Response::HTTP_OK)
    {
        return response()->json(
            [
                'status' => __('messages.success'),
                'message' => $message,
                'data' => $data,
            ],
            $code
        );
    }

    public function errorResponse($message, $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json(
            [
                'status' => __('messages.error'),
                'message' => $message,
            ],
            $code
        );
    }
}
