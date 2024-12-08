<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CategoryController extends ApiController
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse($this->categoryService->all());
    }


    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(CategoryRequest $request):JsonResponse
    {
        if ($request->validated()) {
            return $this->successResponse($this->categoryService->store($request->validated()), ResponseAlias::HTTP_CREATED);
        }
        return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->successResponse($this->categoryService->show($category));
    }


    /**
     * Update the specified resource in storage.
     * @throws \Throwable
     */
    public function update(CategoryRequest $request, Category $category)
    {
        if ($request->validated()) {

            return $this->successResponse($this->categoryService->update($category, $request->validated()), ResponseAlias::HTTP_CREATED);
        }
        return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());
    }

    /**
     * Remove the specified resource from storage.
     * @throws \Throwable
     */
    public function destroy(Category $category)
    {
        $this->categoryService->delete($category);
        return $this->successResponse([
           "message" => "Category deleted successfully"
        ]);
    }
}
