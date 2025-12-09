<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RegistrationPath;
use App\Models\RegistrationPeriod;
use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function sekolah(Request $request)
    {
        $school = auth()->user()->school;
        $periodId = $request->input('period_id');

        $pendaftarCount = $school->activeRegistrations($periodId)->count();
        $pendingCount = $school->activeStatusRegistrations('pending', $periodId)->count();
        $diverifikasi = $school->activeStatusRegistrations('diverifikasi', $periodId)->count();
        $ditolak = $school->activeStatusRegistrations('ditolak', $periodId)->count();
        $lulusCount = $school->activeLulusRegistrations($periodId)->count();
        $tidakLulusCount = $school->activeTidakLulusRegistrations($periodId)->count();

        $pathCounts = $school->registrations();

        if ($periodId) {
            $pathCounts = $pathCounts->where('registration_period_id', $periodId);
        } else {
            $pathCounts = $pathCounts->whereHas('registrationPeriod', function ($q) {
                $q->where('is_open', true);
            });
        }

        $pathCounts = $pathCounts->select('registration_path_id', DB::raw('count(*) as count'))
            ->groupBy('registration_path_id')
            ->pluck('count', 'registration_path_id');

        // Fetch registration paths to map IDs to names
        $registrationPaths = RegistrationPath::all();

        // Prepare the path counts with names
        $formattedPathCounts = [];
        foreach ($registrationPaths as $path) {
            $formattedPathCounts[$path->name] = $pathCounts->get($path->id) ?? 0;
        }

        // Prepare the response data
        $statistics = [
            'pendaftar' => $pendaftarCount,
            'pending' => $pendingCount,
            'diverifikasi' => $diverifikasi,
            'ditolak' => $ditolak,
            'lulus' => $lulusCount,
            'tidak_lulus' => $tidakLulusCount,
            'daya_tampung' => $school->daya_tampung,
            'jumlah_per_jalur' => $formattedPathCounts,
        ];

        // Return JSON response
        return response()->json($statistics);
    }

    public function admin()
    {
        $schoolCount = School::count();
        $sdSchollCount = School::where('jenjang', 'sd')->count();
        $smpSchoolCount = School::where('jenjang', 'smp')->count();
        $currentRegistrationPeriod = RegistrationPeriod::where('is_open', true)->first();

        if ($currentRegistrationPeriod) {
            $startDate = Carbon::parse($currentRegistrationPeriod->start_date);
            $endDate = Carbon::parse($currentRegistrationPeriod->end_date);
            $formattedDateRange = $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y');
            $tahunAjaran = $currentRegistrationPeriod->tahun_ajaran;
            $periode = $formattedDateRange;
        } else {
            $tahunAjaran = '-';
            $periode = 'Tahun Ajaran Tutup';
        }

        $statistics = [
            'sekolah' => $schoolCount,
            'sd' => $sdSchollCount,
            'smp' => $smpSchoolCount,
            'tahun_ajaran' => $tahunAjaran,
            'periode' => $periode,
        ];

        return response()->json($statistics);
    }
}
