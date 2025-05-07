<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Fund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    //
    public function index()
    {
        $donations = Donation::with('user')->get();
        return response()->json([
            'success' => true,
            'data' => $donations,
            'message' => 'Donations fetched successfully'
        ]);
    }





    public function create(Request $request)
{
    $donation = Donation::create($request->all());

    $fund = Fund::latest()->first(); 

    if ($fund) {
        $fund->update(['current_balance' => $fund->current_balance + $donation->amount]);
    } else {
        Fund::create([
            'current_balance' => $donation->amount,
        ]);
    }

    return response()->json([
        'success' => true,
        'data' => $donation,
        'message' => 'Donation created successfully and fund updated'
    ]);
}



}
