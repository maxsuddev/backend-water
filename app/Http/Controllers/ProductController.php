<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProductController extends ApiController
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse($this->productService->all());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        if ($request->validated()){
            return $this->successResponse($this->productService->store($request->validated()), ResponseAlias::HTTP_CREATED);
        }
        return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->successResponse($this->productService->show($product));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        if ($request->validated()){
            return $this->successResponse($this->productService->update($product, $request->validated()), ResponseAlias::HTTP_ACCEPTED);
        }
        return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Throwable
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);
        return $this->successResponse([
            'message' => 'Product deleted successfully'
        ]);
    }
}
