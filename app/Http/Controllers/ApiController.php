<?php

namespace App\Http\Controllers;

use http\Message;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    protected function jsonResponse(mixed $data, int $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }

    protected function successResponse(array $data,  int $code = 200): JsonResponse
    {
        $theData = ['ok' => true, 'message' => 'The operation was completed successfully.'] + $data;

       return $this->jsonResponse($theData,$code);
    }

    protected function errorResponse($message, $status, $errors = []): JsonResponse
    {
        $response = ['error' => $message ,'ok' => false];
        if (!empty($errors)) {
            $response = array_merge($response, $errors);
        }
        return response()->json($response, $status);
    }
}
