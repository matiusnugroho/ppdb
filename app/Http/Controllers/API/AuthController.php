<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Cookie;
use Hash;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    private const ROLE_MAP = [
        'siswa' => 'student',
        'sekolah' => 'school',
    ];

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

        if ($incomingToken) {
            $accessToken = PersonalAccessToken::findToken($incomingToken);

            if (! $accessToken || ! ($accessToken->tokenable instanceof User)) {
                return response()->json(['success' => false, 'message' => 'Invalid token'], 401);
            }

            $user = $accessToken->tokenable;
            $user->loadMissing('student', 'school');

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
            $user->loadMissing('student', 'school');
            $token = $user->createToken('API Token');
            $plainTextToken = $token->plainTextToken;
            $request->session()->regenerate();
        }

        $biodata = $this->resolveBiodata($user);

        $cookie = $this->buildAccessTokenCookie($request, $plainTextToken);

        return response()->json(array_merge(
            $this->buildUserPayload($user, $biodata),
            ['token' => $plainTextToken]
        ))->withCookie($cookie);
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
        ])->withCookie(Cookie::forget('access_token'));
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

    public function me(Request $request)
    {
        $incomingToken = $request->bearerToken()
            ?? $request->cookie('access_token')
            ?? $request->input('token');

        if (! $incomingToken) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $accessToken = PersonalAccessToken::findToken($incomingToken);

        if (! $accessToken || ! ($accessToken->tokenable instanceof User)) {
            return response()->json(['success' => false, 'message' => 'Invalid token'], 401);
        }

        $user = $accessToken->tokenable;
        $user->loadMissing('student', 'school');

        $biodata = $this->resolveBiodata($user);

        $response = response()->json($this->buildUserPayload($user, $biodata));

        if ($request->cookie('access_token')) {
            $response->withCookie($this->buildAccessTokenCookie($request, $incomingToken));
        }

        return $response;
    }

    /**
     * Build the access token cookie in a way that mirrors how Laravel configures
     * its first-party session cookie. That way local HTTP deployments keep the
     * token (no forced logouts between hard refreshes) while HTTPS environments
     * still get the hardened cookie flags provided by the session config.
     */
    private function buildAccessTokenCookie(Request $request, string $plainTextToken)
    {
        $sessionConfig = config('session');

        $path = $sessionConfig['path'] ?? '/';
        $domain = $sessionConfig['domain'] ?? null;
        $secure = $request->isSecure() || ($sessionConfig['secure'] ?? false);
        $sameSite = $sessionConfig['same_site'] ?? 'lax';

        if (! $secure && strtolower((string) $sameSite) === 'none') {
            // Browsers reject SameSite=None cookies that are not marked secure.
            // When the application is served over plain HTTP we fall back to
            // "lax" so the cookie survives the full page reload that happens
            // on direct-link visits in production.
            $sameSite = 'lax';
        }

        return cookie(
            'access_token',
            $plainTextToken,
            60,
            $path,
            $domain,
            $secure,
            true,
            false,
            $sameSite
        );
    }

    private function resolveBiodata(User $user)
    {
        $property = self::ROLE_MAP[$user->role] ?? null;

        return $property ? $user->$property : null;
    }

    private function buildUserPayload(User $user, $biodata = null)
    {
        return [
            'success' => true,
            'user' => $user,
            'biodata' => $biodata,
            'role' => $user->role,
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ];
    }
}
