<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\V1\User\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class ForgotPasswordController extends ApiController
{
    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $email = $request->post('email');
        $user = User::whereEmail($email)->first();

        if ($user && $user->is_admin) {
            return $this->responseError(error: 'Admin user cannot be edited', code: HttpResponse::HTTP_BAD_REQUEST);
        }

        if ($user && !$user->is_admin) {
            return $this->responseSuccess(
                data: ['reset_token' => Password::createToken($user)],
                code: HttpResponse::HTTP_OK
            );
        }

        return $this->responseError(error: 'Invalid email!');
    }
}
