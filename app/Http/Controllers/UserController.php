<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends ApiController
{
    protected UserService $service ;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function index(): JsonResponse
    {
        return $this->successResponse($this->service->all());
    }


    public function show(User $user): JsonResponse
    {
        return $this->successResponse($this->service->show($user));
    }

    public function store(UserRequest $request): JsonResponse
    {

       if($request->validated()){
           return $this->successResponse($this->service->create($request->validated()), ResponseAlias::HTTP_CREATED);
       }

       return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());

    }

    public function update(User $user,UserRequest $request)
    {

        if($request->validated()){
            return $this->successResponse($this->service->update($user,$request->validated()), ResponseAlias::HTTP_CREATED);
        }

        return $this->errorResponse('Invalid data', ResponseAlias::HTTP_UNPROCESSABLE_ENTITY, $request->errors());
    }

    public function destroy(User $user)
    {
        $this->service->delete($user);

        return $this->successResponse([
            "message" => "User deleted"
        ]);
    }


    public function forceDelete(User $user)
    {
        $this->service->forceDelete($user);

        return $this->successResponse([
            "message" => "User has soft deleted"
        ]);
    }
}
