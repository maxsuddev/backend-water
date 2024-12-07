<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RoleController extends ApiController
{
    protected RoleService $service ;

    public function __construct(RoleService $roleService)
    {
        $this->service = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->jsonResponse(
            $this->service->all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): JsonResponse
    {
        if($request->validated()){
            return $this->successResponse($this->service->create($request->validated()), ResponseAlias::HTTP_CREATED);
        }

        return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): JsonResponse
    {
        return $this->successResponse($this->service->show($role));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role): JsonResponse
    {
        if($request->validated()){
            return $this->successResponse(
                $this->service->update($role,($request->validated()))
            );
        }

        return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->service->delete($role);

        return $this->successResponse([
            "message" => "Role deleted"
        ]);
    }



}
