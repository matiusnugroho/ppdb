<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Hash;

class VerifySetupToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->query('token'); // Token from the request
        $hashedToken = env('ROUTE_PROTECTION_TOKEN'); // Hashed token from the .env file

        if (!Hash::check($token, $hashedToken)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }
}
