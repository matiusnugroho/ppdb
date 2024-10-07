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
        $perPage = 20; // Default per page
        $schools = School::with('kecamatan')->paginate($perPage);

        // Prepare the response structure
        $response = [
            'total' => $schools->total(),
            'currentPage' => $schools->currentPage(),
            'nextPage' => $schools->hasMorePages() ? $schools->currentPage() + 1 : null,
            'lastPage' => $schools->lastPage(),
            'data' => $schools->items(), // Optional: Include the items in the response
        ];

        return response()->json($response);
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

    public function getByKecamatan($kecamatanId, $jenjang = null)
    {
        $query = School::select('id', 'nama_sekolah')
            ->where('kecamatan_id', $kecamatanId);

        // If jenjang is provided, add it to the query
        if ($jenjang) {
            $query->where('jenjang', $jenjang);
        }

        $schools = $query->get();

        return response()->json([
            'success' => true,
            'data' => $schools,
        ]);
    }
}
