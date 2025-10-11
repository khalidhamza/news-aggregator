<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(?array $data = null, string $message = 'ok') : JsonResponse
    {
        $result = [
            'status'    => true,
            'message'   => $message,
            'data'      => !empty($data) ? $data : [],
            'errors'    => [],
        ];
        return response()->json($result, 200);
    }

    public static function failed(string $message, int $code, array $data = [], array $errors = []) : JsonResponse
    {
        $result = [
            'status'    => false,
            'message'   => $message,
            'data'      => empty($data) == 0 ? null : $data,
            'errors'    => $errors,
        ];
        if (empty($code)){
            $code = 500;
        }
        return response()->json($result, $code);
    }
    public static function failedValidation($validator) : JsonResponse
    {
        $result = [
            'status'    => false,
            'message'   => $validator->errors()->first(),
            'data'      => null,
            'errors'    => $validator->errors()->toArray(),
        ];
        return response()->json($result, 500);
    }
}
