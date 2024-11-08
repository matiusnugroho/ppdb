<?php

namespace App\Http\Controllers\API;

use App\Exports\SchoolExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolRequest;
use App\Models\RegistrationPath;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validate the request parameters
        $validated = $request->validate([
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|string',
            'jenjang' => 'nullable|string',
            'kecamatan_id' => 'nullable|string',
        ]);

        // Create the query builder
        $query = School::with('kecamatan');

        // Apply filters if they are provided
        if (! empty($validated['jenjang'])) {
            $query->where('jenjang', $validated['jenjang']);
        }

        if (! empty($validated['kecamatan_id'])) {
            $query->where('kecamatan_id', $validated['kecamatan_id']);
        }
        $registrationPaths = RegistrationPath::all();

        // Add registration counts for each path
        $query->with(['registrations' => function ($query) {
            $query->selectRaw('school_id, registration_path_id, count(*) as jalur_count, registration_paths.name')
                ->join('registration_paths', 'registrations.registration_path_id', '=', 'registration_paths.id')
                ->whereHas('registrationPeriod', function ($query) {
                    $query->where('is_open', true);
                })
                ->groupBy('school_id', 'registration_path_id', 'registration_paths.name');
        }]);

        // Check if per_page is 'all' to return all results without pagination
        if (isset($validated['per_page']) && strtolower($validated['per_page']) === 'all') {
            $schools = $query->get();
            $schools = $schools->transform(function ($school) {
                $pathCounts = [];

                foreach ($school->registrations as $jalur) {
                    $pathCounts[$jalur->name] = $jalur->jalur_count;
                }

                // Return the school with the path counts in the desired format
                return $school->setAttribute('path_counts', $pathCounts);
            });

            // Prepare the response structure without pagination
            $response = [
                'total' => $schools->count(),
                'currentPage' => 1,
                'prevPage' => null,
                'nextPage' => null,
                'lastPage' => 1,
                'data' => $schools,
            ];
        } else {
            // Set default pagination value
            $perPage = is_numeric($validated['per_page']) ? (int) $validated['per_page'] : 20;

            // Paginate the results
            $schools = $query->paginate($perPage);
            $schools->getCollection()->transform(function ($school) {
                $pathCounts = [];

                // Assuming 'registrations' has been loaded via 'jalur'
                foreach ($school->registrations as $jalur) {
                    $pathCounts[$jalur->name] = $jalur->jalur_count;
                }

                // Add the 'path_counts' attribute to each school
                $school->setAttribute('path_counts', $pathCounts);

                return $school;
            });

            // Prepare the response structure
            $response = [
                'total' => $schools->total(),
                'currentPage' => $schools->currentPage(),
                'prevPage' => $schools->currentPage() > 1 ? $schools->currentPage() - 1 : null,
                'nextPage' => $schools->hasMorePages() ? $schools->currentPage() + 1 : null,
                'lastPage' => $schools->lastPage(),
                'data' => $schools->items(),
            ];
        }

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

    public function excel(Request $request)
    {
        // Validate the request parameters
        $validated = $request->validate([
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|string',
            'jenjang' => 'nullable|string',
            'kecamatan_id' => 'nullable|string',
        ]);

        // Create the query builder
        $query = School::with('kecamatan');

        // Apply filters if they are provided
        if (! empty($validated['jenjang'])) {
            $query->where('jenjang', $validated['jenjang']);
        }

        if (! empty($validated['kecamatan_id'])) {
            $query->where('kecamatan_id', $validated['kecamatan_id']);
        }

        // Check if per_page is 'all' to return all results without pagination
        if (isset($validated['per_page']) && strtolower($validated['per_page']) === 'all') {
            $schools = $query->get();
        } else {
            // Set default pagination value
            $perPage = is_numeric($validated['per_page'] ?? null) ? (int) $validated['per_page'] : 20;

            // Paginate the results
            $paginatedSchools = $query->paginate($perPage);
            $schools = $paginatedSchools->getCollection();
        }

        //dd($schools);
        return Excel::download(new SchoolExport($schools), 'datasekolah-'.Carbon::now()->format('Y-m-d_His').'.xlsx');

    }

    public function tes()
    {
        $jalur = RegistrationPath::find(1);
        $documentTypes = $jalur->requirements->where('jenjang', 'sd')->pluck('documentType');

        dd($documentTypes);
    }
}
