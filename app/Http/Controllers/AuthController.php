<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    public function login(AuthRequest $request)
    {

        $credentials = $request;

        /**
         * @var $user User
         */
        // Find user by username
        $user = User::where('username', $credentials['username'])->first();


        // Check if user exists and password is correct
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse('Invalid credentials', 401);
        }

        // Delete existing tokens if you want to ensure one token per user
        // $user->tokens()->delete();

        // Create new token
        $token = $user->createToken('auth-token')->plainTextToken;

        $expiresAt = null;


        if ($expiration = config('sanctum.expiration')) {
            $expiresAt = Carbon::now()->addMinutes(( $expiration))->toDateTimeString();
        }

        return $this->jsonResponse([
            'ok' => true,
            'user' => $user->only(['id','name','username']),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt

        ]);
    }

    public function me()
    {
        return ['ok' => true] + auth('api')->user()->only(['id','name','username']);
    }

    public function logout()
    {
        $user = auth('api')->user();

        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return ['message' => 'Successfully logged out'];
    }
}
