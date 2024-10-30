<?php

namespace App\Http\Middleware;

use Closure;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $hashedToken = config('app.route_protection_token'); // Hashed token from the .env file

        if (! Hash::check($token, $hashedToken)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
