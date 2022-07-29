<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\CreateAdminRequest;
use App\Http\Resources\Api\V1\User\UserCollection;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AdminApiController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateAdminRequest $request
     * @return JsonResponse
     */
    public function store(CreateAdminRequest $request): JsonResponse
    {
        $response = $this->userService->create($request->validated());
        return response()->json($response);
    }

    public function userListing(Request $request): UserCollection
    {
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
}
