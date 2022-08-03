<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
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

final class UserApiController extends Controller
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
        return (new UserResource($response))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @return UserResource
     * @throws AuthorizationException
     */
    public function show(): UserResource
    {
        $this->authorize('view', User::class);
        return new UserResource(auth()->user());
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

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy(): Application|ResponseFactory|\Illuminate\Http\Response
    {
        $user = auth()->user();
        $this->authorize('delete', $user);
        $this->userService->delete($user);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
