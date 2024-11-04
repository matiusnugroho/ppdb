<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RegistrationPath;
use Illuminate\Http\Request;
use App\Http\Requests\Jalur\CreateJalurRequest;
use App\Http\Requests\Jalur\UpdateJalurRequest;

class JalurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jalur = RegistrationPath::all();
        return response()->json($jalur);
    }
    public function persyaratan()
    {
        $jalur = RegistrationPath::with('requirements.documentType')->all();
        return response()->json($jalur);
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
    public function store(CreateJalurRequest $request)
    {
        $data = $request->validated();
        $jalur = RegistrationPath::create($data);
        return response()->json([
            'success' => true,
            'data' => $jalur,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(RegistrationPath $registrationPath)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegistrationPath $registrationPath)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJalurRequest $request, RegistrationPath $registrationPath)
    {
        $data = $request->validated();
        $registrationPath->update($data);
        return response()->json([
            'success' => true,
            'data' => $registrationPath,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegistrationPath $registrationPath)
    {
        $registrationPath->delete();
        return response()->json([
            'success' => true,
            'data' => $registrationPath,
        ]);
    }
    public function setPersyaratan(Request $request, RegistrationPath $registrationPath){
        $validatedData = $request->validate([
            'document_type_id' => 'required|exists:document_types,id', // Ensure the document type exists
            'is_required' => 'required|boolean',
            'display_order' => 'nullable|required|integer',
        ]);
        PathRequirement::create([
            'registration_path_id' => $registrationPath->id,
            'document_type_id' => $validatedData['document_type_id'],
            'is_required' => $validatedData['is_required'],
            'display_order' => $validatedData['display_order'],
            'allowed_file_types' => 'pdf',
            'max_file_size' => 2048,
        ]);
    }
}
