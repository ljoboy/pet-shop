<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Category\StoreCategoryRequest;
use App\Http\Requests\Api\V1\Category\UpdateCategoryRequest;
use App\Http\Resources\Api\V1\Category\CategoryShowResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Str;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class CategoryApiController extends Controller
{
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
     * @return CategoryShowResource
     */
    public function store(StoreCategoryRequest $request): CategoryShowResource
    {
        $validated = $request->validated('title');
        $created = Category::create([
            'title' => $validated,
            'slug' => Str::slug($validated),
        ]);

        return new CategoryShowResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoryShowResource
     */
    public function show(Category $category): CategoryShowResource
    {
        return new CategoryShowResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return CategoryShowResource
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryShowResource
    {
        $validated = $request->validated('title');
        $category->update([
            'title' => $validated,
            'slug' => Str::slug($validated),
        ]);
        return new CategoryShowResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category): Response
    {
        $category->delete();
        return response(null, HttpResponse::HTTP_NO_CONTENT);
    }
}
