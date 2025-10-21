<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required_without:token|string',
            'password' => 'required_without:token|string',
            'token' => 'nullable|string',
        ]);
        $login = $request->input('username');
        $password = $request->input('password');
        $incomingToken = $request->input('token');

        $roleMap = [
            'siswa' => 'student',
            'sekolah' => 'school',
        ];

        if ($incomingToken) {
            $accessToken = PersonalAccessToken::findToken($incomingToken);

            if (! $accessToken || ! ($accessToken->tokenable instanceof User)) {
                return response()->json(['success' => false, 'message' => 'Invalid token'], 401);
            }

            $user = $accessToken->tokenable;

            if ($login) {
                $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

                if ($user->$fieldType !== $login) {
                    return response()->json(['success' => false, 'message' => 'Token does not match the provided user'], 401);
                }
            }

            $plainTextToken = $incomingToken;
        } else {
            $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
            $credentials = [
                $fieldType => $login,
                'password' => $password,
            ];

            if (! Auth::attempt($credentials)) {
                return response()->json(['success' => false, 'message' => 'Invalid email or password'], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('API Token');
            $plainTextToken = $token->plainTextToken;
            $request->session()->regenerate();
        }

        $userRole = $user->role;
        $property = $roleMap[$userRole] ?? null;
        $biodata = $property ? $user->$property : null;

        $cookie = cookie(
            'access_token',
            $plainTextToken,
            60,
            '/',
            config('session.domain'),
            $request->isSecure() || config('session.secure', false),
            true,
            false,
            config('session.same_site', 'lax')
        );

        return response()->json([
            'success' => true,
            'user' => $user,
            'biodata' => $biodata,
            'role' => $user->role,
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'token' => $plainTextToken,
        ])->withCookie($cookie);
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
        if (! Hash::check($oldPassword, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password lama salah'], 400);
        }
        $user->password = bcrypt($newPassword);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password changed successfully']);
    }
}
