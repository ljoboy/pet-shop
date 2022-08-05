<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

abstract class AuthController extends ApiController
{
    /**
     * @param  bool  $is_admin
     * @return JsonResponse
     */
    public function logoutAttempt(bool $is_admin): JsonResponse
    {
        if (Auth::check() && (Auth::user()?->is_admin === $is_admin)) {
            Auth::logout();
        }

        return $this->responseSuccess(null);
    }

    /**
     * @param  array  $credentials
     * @param  bool  $is_admin
     * @return JsonResponse
     */
    protected function loginAttempt(array $credentials, bool $is_admin): JsonResponse
    {
        $credentials['is_admin'] = $is_admin;
        $token = auth()->attempt($credentials);
        if ($token) {
            return $this->responseSuccess(['token' => $token]);
        }

        return $this->responseError('failed to authenticate user');
    }
}
