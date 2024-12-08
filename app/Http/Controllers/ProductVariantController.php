<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductVariantRequest;
use App\Models\ProductVariant;
use App\Services\ProductVariantService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductVariantController extends ApiController
{
    protected ProductVariantService $productVariantService;

    public function __construct(ProductVariantService $productVariantService)
    {
        $this->productVariantService = $productVariantService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $this->successResponse($this->productVariantService->all(), ResponseAlias::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(ProductVariantRequest $request)
    {
        if ($request->validated()){
            return $this->successResponse($this->productVariantService->store($request->validated()), ResponseAlias::HTTP_CREATED);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariant $productVariant)
    {
        return $this->successResponse($this->productVariantService->show($productVariant), ResponseAlias::HTTP_OK);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(ProductVariantRequest $request, ProductVariant $productVariant)
    {
        if ($request->validated()){
            return $this->successResponse(ProductVariantService::update($productVariant, $request->validated()), ResponseAlias::HTTP_OK);
        }
        return $this->errorResponse("Invalid request", ResponseAlias::HTTP_BAD_REQUEST, $request->errors());
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Throwable
     */
    public function destroy(ProductVariant $productVariant)
    {
        $this->productVariantService->delete($productVariant);
        return $this->successResponse([
         'message' => 'Product variant deleted successfully'
        ]);
    }
}
