<?php

namespace App\Http\Controllers;

use App\Models\Nav;
use Illuminate\Http\Request;

class NavController extends Controller
{
    /**
     * Display a listing of the nav items.
     */
    public function index()
    {
        // Fetch all nav items
        $navs = Nav::all();
        return response()->json([
            'success' => true,
            'data' => $navs,
            'message' => 'nav fetched successfully'
        ]);
    }

    /**
     * Store a newly created nav item in storage.
     */
    public function create(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'position' => 'required|integer',
        ]);

        // Create a new nav item
        $nav = Nav::create([
            'name' => $request->name,
            'url' => $request->url,
            'position' => $request->position,
        ]);

        return response()->json([
            'success' => true,
            'data' => $nav,
            'message' => 'nav created successfully'
        ]); // Return newly created nav item
    }

    /**
     * Display the specified nav item.
     */
    public function show($id)
    {
        // Find the nav item by ID
        $nav = Nav::find($id);

        if ($nav) {
            return response()->json([
                'success' => true,
                'data' => $nav,
                'message' => 'nav fetched successfully'
            ]);
        }

        return response()->json(['message' => 'Nav item not found'], 404);
    }

    /**
     * Update the specified nav item in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'url' => 'sometimes|string|max:255',
            'position' => 'sometimes|integer',
        ]);

        // Find the nav item by ID
        $nav = Nav::find($id);

        if ($nav) {
            // Update nav attributes
            $nav->update([
                'name' => $request->name ?? $nav->name,
                'url' => $request->url ?? $nav->url,
                'position' => $request->position ?? $nav->position,
            ]);

            return response()->json([
                'success' => true,
                'data' => $nav,
                'message' => 'nav updated successfully'
            ]);
        }

        return response()->json(['message' => 'Nav item not found'], 404);
    }

    /**
     * Remove the specified nav item from storage.
     */
    public function destroy($id)
    {
        // Find the nav item by ID
        $nav = Nav::find($id);

        if ($nav) {
            $nav->delete();
            return response()->json([
                'success' => true,
                'data' => $nav,
                'message' => 'nav deleted successfully'
            ]);
        }

        return response()->json(['message' => 'Nav item not found'], 404);
    }
}
