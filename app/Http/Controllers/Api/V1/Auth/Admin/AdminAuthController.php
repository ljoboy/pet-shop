<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth\Admin;

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Requests\Api\V1\Admin\AdminAuthRequest;
use Illuminate\Http\JsonResponse;

final class AdminAuthController extends AuthController
{
    public function login(AdminAuthRequest $request): JsonResponse
    {
        return $this->loginAttempt($request->only(['email', 'password']), true);
    }
}