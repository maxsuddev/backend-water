<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/json'); // faqat json formatda javob qaytaradi
        // Check if the request has a valid API token
        if (!Auth::guard('api')->check()) {
            return response()->json(['error' => 'Unauthorized','ok' =>false], 401);
        }

        $token = auth('api')->user()->currentAccessToken();

        if ($token && $this->isTokenExpired($token)) {
            $token->delete();
            return response()->json([
                'message' => 'Token has expired',
                'ok' => false
            ], 401);
        }

        return $next($request);
    }




    private function isTokenExpired(PersonalAccessToken $token): bool
    {
        $expiration = config('sanctum.expiration');

        if (!$expiration) {
            return false;
        }

        return Carbon::parse($token->created_at)
            ->addMinutes( $expiration)
            ->isPast();
    }
}
