<?php

namespace App\Http\Controllers;

use App\Http\Requests\SizeRequest;
use App\Models\Size;
use App\Services\SizeService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class SizeController extends ApiController
{
    protected SizeService $sizeService;


    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse($this->sizeService->all());
    }


    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(SizeRequest $request)
    {
        if ($request->validated())
        {
            return $this->successResponse($this->sizeService->store($request->validated()), ResponseAlias::HTTP_CREATED);
        }
        return $this->errorResponse("Invalid data", ResponseAlias::HTTP_BAD_REQUEST, $request->errors());
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        $this->SuccessResponse($this->sizeService->show($size));
    }


    /**
     * Update the specified resource in storage.
     * @throws \Throwable
     */
    public function update(SizeRequest $request, Size $size)
    {
        if ($request->validated())
        {
            return $this->successResponse($this->sizeService->update($size, $request->validated()));
        }
        return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        $this->sizeService->delete($size);
        return $this->successResponse([

        ]);
    }
}
