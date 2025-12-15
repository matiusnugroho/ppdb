<?php

namespace App\Http\Controllers\API;

use App\Exports\SchoolExport;
use App\Exports\SchoolWithDataExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMySchoolRequest;
use App\Http\Requests\StoreSchoolRequest;
use App\Imports\SchoolsImport;
use App\Models\RegistrationPath;
use App\Models\School;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Hash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

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
            'search' => 'nullable|string',
        ]);

        // Create the query builder
        $query = School::with(['kecamatan', 'user']);

        // Apply filters if they are provided
        if (! empty($validated['jenjang'])) {
            $query->where('jenjang', $validated['jenjang']);
        }

        if (! empty($validated['kecamatan_id'])) {
            $query->where('kecamatan_id', $validated['kecamatan_id']);
        }

        if (! empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                    ->orWhere('npsn', 'like', "%{$search}%")
                    ->orWhere('nss', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
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
    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        $school->load(['kecamatan', 'user']);

        return response()->json([
            'success' => true,
            'data' => $school,
        ]);
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
        $validated = $request->validate([
            'nama_sekolah' => 'required|string',
            'nss' => 'nullable|string',
            'npsn' => 'nullable|string',
            'jenjang' => 'required|string',
            'alamat' => 'required|string',
            'no_telp' => 'nullable|string',
            'email' => 'required|email',
            'nama_kepsek' => 'required|string',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'daya_tampung' => 'nullable|integer',
            'username' => 'nullable|string|unique:users,username,' . $school->user_id,
            'password' => 'nullable|string|min:6',
        ]);

        $school->update([
            'nama_sekolah' => $validated['nama_sekolah'],
            'nss' => $validated['nss'],
            'npsn' => $validated['npsn'],
            'jenjang' => $validated['jenjang'],
            'alamat' => $validated['alamat'],
            'no_telp' => $validated['no_telp'],
            'email' => $validated['email'],
            'nama_kepsek' => $validated['nama_kepsek'],
            'kecamatan_id' => $validated['kecamatan_id'],
            'daya_tampung' => $validated['daya_tampung'],
        ]);

        $user = $school->user;
        if ($user) {
            $user->email = $validated['email'];
            if (!empty($validated['username'])) {
                $user->username = $validated['username'];
            }
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();
        }

        $school->load(['kecamatan', 'user']);

        return response()->json([
            'success' => true,
            'data' => $school,
        ]);
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
        return Excel::download(new SchoolExport($schools), 'datasekolah-' . Carbon::now()->format('Y-m-d_His') . '.xlsx');
    }

    public function excelWithData(Request $request)
    {
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
        } else {
            // Set default pagination value
            $perPage = is_numeric($validated['per_page'] ?? null) ? (int) $validated['per_page'] : 20;

            // Paginate the results
            $paginatedSchools = $query->paginate($perPage);
            $schools = $paginatedSchools->getCollection();
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
        }

        //dd($schools);
        return Excel::download(new SchoolWithDataExport($schools, $registrationPaths), 'datasekolah-' . Carbon::now()->format('Y-m-d_His') . '.xlsx');
    }

    public function tes()
    {
        $jalur = RegistrationPath::find(1);
        $documentTypes = $jalur->requirements->where('jenjang', 'sd')->pluck('documentType');

        dd($documentTypes);
    }

    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Import the data using the SchoolsImport class
        try {
            Excel::import(new SchoolsImport, $file);

            return response()->json([
                'success' => true,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function me(Request $request)
    {
        $school = $request->user()?->school;

        if (! $school) {
            return response()->json([
                'success' => false,
                'message' => 'Data sekolah tidak ditemukan untuk pengguna ini',
            ], Response::HTTP_NOT_FOUND);
        }

        $school->load('kecamatan');

        return response()->json([
            'success' => true,
            'data' => $school,
        ]);
    }

    public function updateMyProfile(UpdateMySchoolRequest $request)
    {
        $user = $request->user();
        $school = $user?->school;

        if (! $school) {
            return response()->json([
                'success' => false,
                'message' => 'Data sekolah tidak ditemukan untuk pengguna ini',
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validated();

        // Update user email if provided
        if (isset($validated['email'])) {
            $user->email = $validated['email'];
            $user->save();
        }

        $school->fill($validated);
        $school->save();

        $school->refresh()->load('kecamatan');

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user->fresh(),
                'school' => $school,
            ],
        ]);
    }
}
