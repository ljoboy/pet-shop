<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\V1\Category\StoreCategoryRequest;
use App\Http\Requests\Api\V1\Category\UpdateCategoryRequest;
use App\Http\Resources\Api\V1\Category\CategoryShowResource;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Str;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class CategoryApiController extends ApiController
{

    public function __construct()
    {
        $this->authorizeResource(CategoryPolicy::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $sortBy = $request->get('sortBy') ?? 'created_at';
        $direction = $request->get('desc', false) ? 'desc' : 'asc';
        $limit = $request->get('limit', 10);

        $categories = Category::orderBy($sortBy, $direction)->paginate($limit);
        return CategoryShowResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $validated = $request->validated('title');
        $created = Category::create([
            'title' => $validated,
            'slug' => Str::slug($validated),
        ]);

        return $this->responseSuccess(data: new CategoryShowResource($created), code: HttpResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return $this->responseSuccess(data: new CategoryShowResource($category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $validated = $request->validated('title');
        $category->update([
            'title' => $validated,
            'slug' => Str::slug($validated),
        ]);
        return $this->responseSuccess(data: new CategoryShowResource($category));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();
        return $this->responseSuccess(data: null, code: HttpResponse::HTTP_NO_CONTENT);
    }
}
