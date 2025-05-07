<?php

namespace App\Http\Controllers;

use App\Models\AffectedType;
use Illuminate\Http\Request;

class AffectedTypeController extends Controller
{
    //
    public function index()
    {   
        $affectedTypes = AffectedType::all();
    
        return response()->json([
            'success' => true,
            'data' => $affectedTypes,
            'message' => "Affected types fetched successfully"
        ]);
    }

    public function create(Request $request)
    {
        $affectedType = AffectedType::create($request->all());
    
        return response()->json([
            'success' => true,
            'data' => $affectedType,
            'message' => "Affected type created successfully"
        ]);
    }

    public function show(string $id)
    {
        $affectedType = AffectedType::find($id);

        return response()->json([
            'success' => true,
            'data' => $affectedType,
            'message' => "Affected type fetched successfully"
        ]);
    }

    public function update(Request $request, string $id)
    {
        $affectedType = AffectedType::find($id);
        $affectedType->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $affectedType,

            'message' => "Affected type updated successfully"
        ]);
    }

    public function destroy(string $id)
    {
        $affectedType = AffectedType::find($id);
        $affectedType->delete();

        return response()->json([
            'success' => true,
            'message' => "Affected type deleted successfully"
        ]);
    }
}
