<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUpdateAkunRequest;
use Hash;
class AdminController extends Controller
{
    public function updateAkun(AdminUpdateAkunRequest $request)
    {
        $validatedData = $request->validated();
        $user = auth()->user();

        // Update username if it exists in the validated data
        if (isset($validatedData['username'])) {
            $user->username = $validatedData['username'];
        }

        // Update password if the current password matches and a new password is provided
        if (isset($validatedData['currentPassword']) && isset($validatedData['newPassword'])) {
            if (Hash::check($validatedData['currentPassword'], $user->password)) {
                $user->password = Hash::make($validatedData['newPassword']);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect.',
                    'errors' => ['currentPassword' => ['Password salah.']],
                ], 400);
            }
        }

        // Save changes to the user
        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user,
        ], 200);
    }
}
