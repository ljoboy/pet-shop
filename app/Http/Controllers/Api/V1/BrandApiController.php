<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Brand\StoreBrandRequest;
use App\Http\Requests\Api\V1\Brand\UpdateBrandRequest;
use App\Http\Resources\Api\V1\Brand\ShowBrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class BrandApiController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Brand::class);
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

        $brands = Brand::orderBy($sortBy, $direction);
        $brands->paginate($limit);
        return ShowBrandResource::collection($brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBrandRequest $request
     * @return ShowBrandResource
     */
    public function store(StoreBrandRequest $request)
    {
        $brand_infos = $request->validated();
        $brand_infos['slug'] = Str::slug($brand_infos['title']);

        $brand = Brand::create($brand_infos);

        return new ShowBrandResource($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param Brand $brand
     * @return ShowBrandResource
     */
    public function show(Brand $brand): ShowBrandResource
    {
        return new ShowBrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBrandRequest $request
     * @param Brand $brand
     * @return ShowBrandResource
     */
    public function update(UpdateBrandRequest $request, Brand $brand): ShowBrandResource
    {
        $brand_infos = $request->validated();
        $brand_infos['slug'] = Str::slug($brand_infos['title']);

        $brand->update($brand_infos);

        return new ShowBrandResource($brand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return Response
     */
    public function destroy(Brand $brand): Response
    {
        $brand->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
