<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\CreateUserRequest;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Services\UserService;
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
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $response = $this->userService->create($request->validated());
        return (new UserResource($response))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @return UserResource
     */
    public function show(): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = auth()->user();
        $this->userService->update($request->validated(), $user);

        return (new UserResource($user))->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(): Application|ResponseFactory|\Illuminate\Http\Response
    {
        $data['message'] = 'An error occurred';
        if ($this->userService->delete(auth()->user())) {
            $data['message'] = null;
        }
        return response($data, Response::HTTP_NO_CONTENT);
    }
}
