<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            'tidak_lulus' => $tidakLulusCount
        ];

        // Return JSON response
        return response()->json($statistics);
    }
}
