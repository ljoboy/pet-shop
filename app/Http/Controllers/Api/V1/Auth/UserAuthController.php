<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Requests\Api\V1\User\UserAuthRequest;
use Illuminate\Http\JsonResponse;

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
