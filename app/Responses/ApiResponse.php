<?php

namespace App\Responses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    const SUCCESS = "success";
    const ERROR = "error";

    public static function success($data = [], string $message = 'Success', int $status = 200): JsonResponse
    {
        foreach ($data as $key => $value) {
            if ($value instanceof Model && method_exists($value, 'toResource')) {
                $data[$key] = $value->toResource();
            }
        }

        return response()->json([
            'status' => static::SUCCESS,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error(string $message = 'Error', int $status = 400, $errors = []): JsonResponse
    {
        return response()->json([
            'status' => static::ERROR,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
