<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\V1\User\CreateUserRequest;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UserApiController extends ApiController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);
        $response = $this->userService->create($request->validated());
        return $this->responseSuccess(data: new UserResource($response), code: Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(): JsonResponse
    {
        $user = auth()->user();
        $this->authorize('view', $user);
        return $this->responseSuccess(data: new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = auth()->user();
        $this->authorize('update', $user);
        $this->userService->update($request->validated(), $user);

        return $this->responseSuccess(data: new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(): JsonResponse
    {
        $user = auth()->user();
        $this->authorize('delete', $user);
        $this->userService->delete($user);
        return $this->responseSuccess(data: null, code: Response::HTTP_NO_CONTENT);
    }
}
