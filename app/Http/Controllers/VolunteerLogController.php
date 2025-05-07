<?php

namespace App\Http\Controllers;

use App\Models\VolunteerLog;
use Illuminate\Http\Request;

class VolunteerLogController extends Controller
{
    //
    // public function clockIn(Request $request)
    // {
    //     $log = new VolunteerLog();
    //     $log->user_id = $request->user_id;
    //     $log->tcenter_id = $request->tcenter_id;
    //     $log->clock_in = now();
    //     $log->save();



    //     return response()->json(['success' => true, 'data' => $log]);
        
    // }

    public function clockIn(Request $request)
    {
        $log = new VolunteerLog();
        $log->user_id = $request->user_id;
        $log->tcenter_id = $request->tcenter_id;
        $log->clock_in = now();
        $log->landingcard_ids = $request->landing_card_ids[0]; // Take only the first selected
        $log->save();
    
        return response()->json(['success' => true, 'data' => $log]);
    }
    
    

    public function clockOut(Request $request)
{
    $log = VolunteerLog::where('user_id', $request->user_id)
        ->where('tcenter_id', $request->tcenter_id)

        ->whereNull('clock_out')

        ->latest()
        ->first();

    if ($log) {
        $log->clock_out = now();
        $log->total_hours = now()->diffInMinutes($log->clock_in); // Store minutes
        $log->save();
        return response()->json(['success' => true, 'data' => $log]);
    }

    return response()->json(['success' => false, 'message' => 'No active clock-in found.']);
}

public function getLogs($userId, $tcenterId)
{

    $logs = VolunteerLog::with('landingCard')->where('user_id', $userId)
        ->where('tcenter_id', $tcenterId)
        ->orderBy('clock_in', 'desc')
        ->get();

    return response()->json(['success' => true, 'data' => $logs]);
}
}
