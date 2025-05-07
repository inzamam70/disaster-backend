<?php

namespace App\Http\Controllers;

use App\Models\Transection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransectionController extends Controller
{
    //

    // public function index()
    // {
    //     $transections = Transection::with('aid')->get();
    //     return response()->json([
    //         'success' => true,
    //         'data' => $transections,
    //         'message' => 'Transections fetched successfully'
    //     ]);
    // }

    public function index()
    {
        $transections = Transection::with('aid')->get();
        return response()->json([
            'success' => true,
            'data' => $transections,
            'message' => 'Transections fetched successfully'
        ]);
    }


    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'aid_id' => 'required|exists:aids,id',
            'amount' => 'required',
            'payment_method' => 'required'
        ]);

        $transection = Transection::create($validatedData);

        return response()->json([
            'success' => true,
            'data' => $transection,
            'message' => 'Transection created successfully'
        ]);
    }   

    public function show(string $id)
    {
        $transection = Transection::find($id);
        return response()->json([
            'success' => true,
            'data' => $transection,
            'message' => 'Transection fetched successfully'
        ]);
    }

    public function update(Request $request, string $id)
    {
        $transection = Transection::find($id);
        $transection->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $transection,
            'message' => 'Transection updated successfully'
        ]);
    }

    public function destroy(string $id)
    {
        $transection = Transection::find($id);
        $transection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transection deleted successfully'
        ]);
    }




}
