<?php

namespace App\Http\Controllers;

use App\Events\AidCreated;
use App\Models\Aid;
use App\Models\Landingcard;
use App\Models\User;
use Illuminate\Http\Request;

class AidController extends Controller
{
    public function index()
    {
        $aids = Aid::with('landingcard')->get();


        return response()->json([
            'success' => true,
            'data' => $aids,
            'message' => "Aids fetched successfully"
        ]);
    }

    public function create(Request $request)
    {
        $aid = Aid::create($request->all());
    
        // Trigger the AidCreated event
        event(new AidCreated($aid));
    
        return response()->json([
            'success' => true,
            'data' => $aid,
            'message' => "Aid created successfully"
        ]);
    }
    

    public function show(string $id)
    {
        $aid = Aid::find($id);

        return response()->json([
            'success' => true,
            'data' => $aid,
            'message' => "Aid fetched successfully"
        ]);
    }

    public function update(Request $request, string $id)
    {
        $aid = Aid::find($id);
        $aid->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $aid,

            'message' => "Aid updated successfully"
        ]);
    }


    public function updateStatus(Request $request, $id)
    {
        
        $aid = Aid::find($id);
        $aid->update([
            'status' => $request->status	
        ]);
       

        return response()->json([
            'success' => true,
            'data' => $aid,
            'message' => "Aid status updated successfully"
        ]);
    }


    public function destroy(string $id)
    {
        $aid = Aid::find($id);
        $aid->delete();

        return response()->json([
            'success' => true,
            'message' => "Aid deleted successfully"
        ]);
    }
}
