<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function sendError($errorMessages = [], $code = Response::HTTP_NOT_FOUND)
    {
        $response = [
            'success' => false,
            'error' => [
                'code' => $code,
                'message' => $errorMessages,
            ],
        ];

        throw new HttpResponseException(response()->json($response, $code));
    }
}
