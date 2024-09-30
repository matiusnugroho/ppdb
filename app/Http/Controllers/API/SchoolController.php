<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolRequest;
use App\Models\School;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreSchoolRequest $request)
    {
        $validatedData = $request->validated();
        //dd($validatedData);
        $user = User::create([
            'username' => $validatedData['username'] ?? null, // Allow name to be null
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $user->assignRole('sekolah');
        $school = $user->school()->create($validatedData);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'school' => $school,
            ],
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        //
    }
}
