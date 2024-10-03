<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegistrationPeriodRequest;
use App\Models\RegistrationPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function getOpenPeriods()
    {
        $openPeriods = RegistrationPeriod::where('is_open', true)->get();

        return response()->json(
            $openPeriods
        );
    }

    public function isTodayOpened()
    {
        $today = Carbon::today();
        $openPeriods = RegistrationPeriod::where('is_open', true)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->get();

        // Check if there are any periods open today
        $isPeriodOpenToday = $openPeriods->isNotEmpty();

        return response()->json($isPeriodOpenToday);
    }

    //Buka pendaftaran tahun ajaran baru
    public function bukaPendaftaran(StoreRegistrationPeriodRequest $request)
    {
        if(!$request->user()->can('create_registration_period')) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }    
        // Update previous periods and create new period
        RegistrationPeriod::where('is_open', true)->update(['is_open' => false]);
        $data = $request->validated();
        $data['is_open'] = true;
        $period = RegistrationPeriod::create($data);
    
        return response()->json($period);
    }
    
}
