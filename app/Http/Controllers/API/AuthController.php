<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Auth;
use Hash;
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

    public function logout(Request $request)
    {
        auth()->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the session token
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }
    public function changePassword(Request $request)
    {
        $oldPassword = $request->password_lama;
        $newPassword = $request->password_baru;
        $user = Auth::user();
        if (!Hash::check($oldPassword, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama salah'], 400);
        }
        $user->password = bcrypt($newPassword);
        $user->save();
        return response()->json(['success' => true, 'message' => 'Password changed successfully']);
    }
}
