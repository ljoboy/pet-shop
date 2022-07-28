<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;

final class PasswordResetController extends Controller
{

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $status_code = Response::HTTP_UNPROCESSABLE_ENTITY;
        $data = [
            'error' => 'Invalid or expired token'
        ];
        $credentials = $request->only(['email','token', 'password', 'password_confirmation']);
        $response = Password::reset($credentials, function (User $user, string $password) {
            $user->fill([
                'password' => Hash::make($password)
            ])->save();
        });

        if ($response === Password::PASSWORD_RESET) {
            $status_code = Response::HTTP_OK;
            $data['message'] = "Password has been successfully updated";
            $data['error'] = null;
        }

        return response()->json($data, $status_code);
    }
}