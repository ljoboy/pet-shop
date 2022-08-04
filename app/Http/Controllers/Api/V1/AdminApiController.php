<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\V1\Admin\CreateAdminRequest;
use App\Http\Requests\Api\V1\User\UpdateUserRequest;
use App\Http\Resources\Api\V1\User\UserCollection;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Http\Resources\Api\V1\User\UserWithTokenResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class AdminApiController extends ApiController
{
    public function __construct(private readonly UserService $userService)
    {
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAdminRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateAdminRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);
        $user = User::create($request->validated());
        return $this->responseSuccess(new UserWithTokenResource($user));
    }

    /**
     * @param Request $request
     * @return UserCollection
     * @throws AuthorizationException
     */
    public function userListing(Request $request): UserCollection
    {
        $this->authorize('viewAny', User::class);
        $sortBy = $request->get('sortBy') ?? 'id';
        $direction = $request->get('desc', false) ? 'desc' : 'asc';
        $limit = $request->get('limit', 10);


        $users = User::orderBy($sortBy, $direction);

        $request->get('first_name') && $users->where('first_name', 'LIKE', '%' . $request->get('first_name') . '%');
        $request->get('email') && $users->where('email', 'LIKE', '%' . $request->get('email') . '%');
        $request->get('phone') && $users->where('phone_number', '=', $request->get('phone'));
        $request->get('address') && $users->where('address', 'LIKE', '%' . $request->get('address') . '%');
        $request->get('created_at') && $users->where('created_at', '=', $request->get('created_at'));
        $request->get('marketing') && $users->where('is_marketing', '=', $request->get('marketing'));

        $users = $users->paginate($limit);
        return new UserCollection($users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);
        $this->userService->update($request->validated(), $user);

        return $this->responseSuccess(data: new UserResource($user), code: HttpResponse::HTTP_ACCEPTED);
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->userService->delete($user);
        return $this->responseSuccess(data: null, code: HttpResponse::HTTP_NO_CONTENT);
    }
}
