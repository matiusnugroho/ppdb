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
            'password' => 'required|string|',
        ]);
        $login = $request->input('username');
        $password = $request->input('password');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token');
            $roleMap = [
                'siswa' => 'student',
                'sekolah' => 'school',
            ];
            $request->session()->regenerate();
            $userRole = $user->role;
            $property = $roleMap[$userRole] ?? null;
            $biodata = $property ? $user->$property : null;

            return response()->json([
                'success' => true,
                'user' => $user,
                'biodata' => $biodata,
                'role' => $user->role,
                'permissions' => $user->getAllPermissions()->pluck('name'), // Assuming user has permissions
            ])->cookie('access_token', $token->plainTextToken, 60, null, null, true, true);            
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid email or password'], 401);
        }
    }
}
