<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

abstract class AuthController
{
    public function logout(): JsonResponse
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * @param array $credentials
     */
    protected function loginAttempt(array $credentials, bool $is_admin): JsonResponse
    {
        $response = [
            'success' => 0,
            'data' => [],
            'error' => 'Failed to authenticate user',
            'errors' => [],
            'trace' => [],
        ];
        $http_response = HttpResponse::HTTP_UNPROCESSABLE_ENTITY;
        $credentials['is_admin'] = $is_admin;

        $token = auth()->attempt($credentials);
        if ($token) {
            $http_response = HttpResponse::HTTP_OK;
            $response['data'] = $token;
            $response['error'] = null;
            $response['success'] = true;
        }

        return response()->json($response, $http_response);
    }
}