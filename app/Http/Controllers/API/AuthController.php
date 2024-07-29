<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // Get the login input
        $login = $request->input('username');
        $password = $request->input('password');

        // Determine if the login input is an email or username
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Attempt to authenticate the user with the appropriate field
        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token');

            return response()->json([
                'success' => true,
                'token' => $token->plainTextToken,
                'role' => $user->getRoleNames(), // Assuming user has roles
                'permissions' => $user->getAllPermissions()->pluck('name'), // Assuming user has permissions
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid email or password'], 401);
        }
    }
}
