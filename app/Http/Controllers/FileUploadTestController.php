<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Storage;
use Str;

class FileUploadTestController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'foto' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->file('foto')->isValid()) {
            // Retrieve the authenticated user's student's nama
            $user = auth()->user();
            if (! $user || ! $user->student || ! $user->student->nama) {
                return response()->json(['error' => 'User or student name not found.'], 400);
            }

            $nama = $user->student->nama;
            Log::info('Student name retrieved', ['nama' => $nama]);

            // Convert nama to snake case
            $snakeCaseNama = Str::snake($nama);
            Log::info('Converted to snake case', ['snake_case_nama' => $snakeCaseNama]);

            // Get the file extension
            $extension = $request->file('foto')->getClientOriginalExtension();
            Log::info('File extension retrieved', ['extension' => $extension]);

            // Create a custom file name
            $fileName = $snakeCaseNama.'_'.time().'.'.$extension;
            Log::info('Custom file name created', ['file_name' => $fileName]);

            // Store the file with the custom name in the 'uploads' directory
            $path = $request->file('foto')->storeAs('uploads', $fileName, 'public');
            Log::info('File stored', ['path' => $path]);

            return response()->json(['path' => $path, 'url' => asset(Storage::url($path))], 201);
        }

        return response()->json(['error' => 'Invalid file upload.'], 400);
    }
}
