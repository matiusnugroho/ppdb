<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RegistrationPeriod;
use App\Models\School;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function sekolah()
    {
        $school = auth()->user()->school;
        $pendaftarCount = $school->activeRegistrations()->count();
        $pendingCount = $school->activeStatusRegistrations('pending')->count();
        $diverifikasi = $school->activeStatusRegistrations('diverifikasi')->count(); // Assuming 'pending' is a valid status
        $ditolak = $school->activeStatusRegistrations('ditolak')->count();
        $lulusCount = $school->activeLulusRegistrations()->count();
        $tidakLulusCount = $school->activeTidakLulusRegistrations()->count();

        // Prepare the response data
        $statistics = [
            'pendaftar' => $pendaftarCount,
            'pending' => $pendingCount,
            'diverifikasi' => $diverifikasi,
            'ditolak' => $ditolak,
            'lulus' => $lulusCount,
            'tidak_lulus' => $tidakLulusCount,
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
        $startDate = Carbon::parse($currentRegistrationPeriod->start_date);
        $endDate = Carbon::parse($currentRegistrationPeriod->end_date);
        $formattedDateRange = $startDate->translatedFormat('d F Y').' - '.$endDate->translatedFormat('d F Y');

        $statistics = [
            'sekolah' => $schoolCount,
            'sd' => $sdSchollCount,
            'smp' => $smpSchoolCount,
            'tahun_ajaran' => $currentRegistrationPeriod->tahun_ajaran,
            'periode' => $formattedDateRange,
        ];

        return response()->json($statistics);
    }
}
