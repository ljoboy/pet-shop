<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth\User;

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Requests\Api\V1\User\ResetPasswordRequest;
use App\Http\Requests\Api\V1\User\UserAuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Str;
use Symfony\Component\HttpFoundation\Response;

final class UserAuthController extends AuthController
{
    public function login(UserAuthRequest $request): JsonResponse
    {
        return $this->loginAttempt($request->only(['email', 'password']), false);
    }

    public function logout(): JsonResponse
    {
        return $this->logoutAttempt(false);
    }
}
