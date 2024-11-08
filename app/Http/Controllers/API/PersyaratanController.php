<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PathRequirement;
use Illuminate\Http\Request;

class PersyaratanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pathRequirements = PathRequirement::with('documentType', 'registrationPath')->get();

        // Group the data by `registration_path_id` and then by `jenjang`
        $groupedData = $pathRequirements->groupBy('registrationPath.name')->map(function ($group) {
            return $group->groupBy('jenjang')->map(function ($requirements) {
                return $requirements->map(function ($requirement) {
                    return [
                        'id' => $requirement->id,
                        'document_type_id' => $requirement->document_type_id,
                        'document_type' => $requirement->documentType, // Includes related model
                        'is_required' => $requirement->is_required,
                        'allowed_file_types' => $requirement->allowed_file_types,
                        'max_file_size' => $requirement->max_file_size,
                        'display_order' => $requirement->display_order,
                        'validation_rules' => $requirement->validation_rules,
                        'created_at' => $requirement->created_at,
                        'updated_at' => $requirement->updated_at,
                    ];
                });
            });
        });

        // Return as a JSON response (e.g., in a controller)
        return response()->json($groupedData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PathRequirement $pathRequirement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PathRequirement $pathRequirement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PathRequirement $pathRequirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PathRequirement $pathRequirement)
    {
        //
    }
}
