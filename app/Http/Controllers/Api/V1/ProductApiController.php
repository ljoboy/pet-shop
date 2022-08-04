<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\V1\Product\StoreProductRequest;
use App\Http\Requests\Api\V1\Product\UpdateProductRequest;
use App\Http\Resources\Api\V1\Product\ProductShowResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class ProductApiController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(Product::class);
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
        $products = Product::with(['category', 'brand'])->orderBy($sortBy, $direction);

        $request->get('category') && $products->where('category_uuid', '=', $request->get('category'));
        $request->get('price') && $products->where('price', '<', $request->get('price'));
        $request->get('brand') && $products->where('metadata->brand', '=', $request->get('brand'));
        $request->get('title') && $products->where('title', 'LIKE', "%{$request->get('title')}%");

        $products = $products->paginate($limit);
        return ProductShowResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        return $this->responseSuccess(data: new ProductShowResource($product));
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return $this->responseSuccess(data: new ProductShowResource($product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return $this->responseSuccess(data: new ProductShowResource($product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return $this->responseSuccess(data: null, code: HttpResponse::HTTP_NO_CONTENT);
    }
}
