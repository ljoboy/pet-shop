<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\ForgotPasswordRequest;
use App\Http\Requests\Api\V1\User\ResetPasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class PasswordResetController extends Controller
{

    public function resetPassword(ResetPasswordRequest $request)
    {
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $error = 'Invalid email';
        $response = [];
        $email = $request->post('email');
        $user = User::whereEmail($email)->first();
        $status_code = HttpResponse::HTTP_NOT_FOUND;

        if ($user && $user->is_admin == 1) {
            $error = 'Admin user cannot be edited';
            $status_code = HttpResponse::HTTP_BAD_REQUEST;
        }

        if ($user && $user->is_admin == 0) {
            $status_code = HttpResponse::HTTP_OK;
            $response = ['reset_token' => Password::createToken($user)];
            $error = null;
        }

        $data = [
            'error' => $error,
            'data' => $response
        ];

        return response()->json($data, $status_code);
    }
}
