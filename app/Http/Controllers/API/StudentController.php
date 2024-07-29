<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use App\Models\User;
use Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Student::with('user')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $validatedData = $request->validated();
        //dd($validatedData);
        $user = User::create([
            'username' => $validatedData['username'] ?? null, // Allow name to be null
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $user->assignRole('siswa');
        $student = $user->student()->create($validatedData);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'student' => $student,
            ],
        ], 201);

    }

    public function updateMyprofile(UpdateStudentRequest $request)
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        if ($user->can('edit_my_profile_siswa')) {
            $userData = array_intersect_key($validatedData, array_flip(['email', 'username', 'password']));
            $studentData = array_intersect_key($validatedData, array_flip(['nama', 'tempat_lahir', 'tanggal_lahir', 'nama_bapak_ibu', 'nik', 'no_kk', 'no_hp_ortu']));

            // Hash the password if it's present in the validated data
            if (isset($userData['password'])) {
                $userData['password'] = bcrypt($userData['password']);
            }

            //dd($request,$validatedData, $userData, $studentData);

            // Update the user and student models
            $user->update($userData);
            $user->student()->update($studentData);

            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user->refresh(),
                ],
            ], 200);
        }

        return response()->json([
            'success' => false,
        ], 403);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    public function me()
    {
        $user = auth()->user();

        if (! $user->hasRole('siswa')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda Bukan siswa, login terlebih dahulu',
            ], 200);
        }

        $user->load('student', 'roles');

        // Adding permissions to the user model
        $permissions = $user->getAllPermissions()->pluck('name');
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'permissions' => $permissions
            ],
        ], 200);
    }
}
