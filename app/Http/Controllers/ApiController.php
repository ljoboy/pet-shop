<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller
{
    /**
     * @param mixed $data
     * @param string|null $error
     * @param int $code
     * @param array $errors
     * @param array $extra
     * @param bool $success
     * @return JsonResponse
     */
    private function response(
        mixed $data,
        string $error = null,
        array $errors = [],
        int $code = 422,
        array $extra = [],
        bool $success = false
    ): JsonResponse {
        $response = [
            'success' => $success ? 1 : 0,
            'data' => $data,
            'error' => $error,
            'errors' => $errors,
        ];

        if (!$success) {
            $response['trace'] = $extra;
        }

        if ($success) {
            $response['extra'] = $extra;
        }

        return response()->json($response, $code);
    }

    /**
     * @param string|null $error
     * @param array $errors
     * @param int $code
     * @param array $trace
     * @return JsonResponse
     */
    protected function responseError(
        string $error = null,
        array $errors = [],
        int $code = 422,
        array $trace = []
    ): JsonResponse {
        return $this->response(data: [], error: $error, errors: $errors, code: $code, extra: $trace, success: false);
    }

    protected function responseSuccess(
        mixed $data,
        array $extra = [],
        int $code = 200
    ): JsonResponse {
        return $this->response(data: $data, code: $code, extra: $extra, success: true);
    }
}
