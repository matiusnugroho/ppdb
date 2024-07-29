<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token');

            return response()->json([
                'success' => true,
                'token' => $token->plainTextToken,
                'role' => $user->getRoleNames(), // Assuming user has roles
                'permissions' => $user->getAllPermissions()->pluck('name') // Assuming user has permissions
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid email or password'], 401);
        }
    }
}
