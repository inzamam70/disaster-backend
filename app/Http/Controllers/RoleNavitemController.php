<?php

namespace App\Http\Controllers;

use App\Models\RoleNavitem;
use Illuminate\Http\Request;

class RoleNavItemController extends Controller
{
    /**
     * Display a listing of role nav items.
     */
    public function index()
    {
        // Fetch all RoleNavItem entries
        $roleNavItems = RoleNavitem::all();
        return response()->json(
            [
                'success' => true,
                'data' => $roleNavItems,
                'message' => 'RoleNavItems fetched successfully'
            ]
        );
    }

    /**
     * Store a newly created role nav item in storage.
     */
    public function create(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'roleId' => 'required|exists:roles,id',
            'navItemIds' => 'required|array', // Ensure navItemIds is an array
            'navItemIds.*' => 'exists:navs,id', // Each item in the array must exist in navs table
        ]);
    
        $roleId = $request->roleId;
        $navItemIds = $request->navItemIds;
    
        // Store each nav item with the role
        $roleNavItems = [];
        foreach ($navItemIds as $navId) {
            $roleNavItems[] = RoleNavitem::create([
                'role_id' => $roleId,
                'nav_id' => $navId,
            ]);
        }
    
        return response()->json(
            [
                'success' => true,
                'data' => $roleNavItems,
                'message' => 'RoleNavItems created successfully',
            ],
            201
        ); // Return newly created RoleNavItems
    }
    

    /**
     * Display the specified role nav item.
     */
    public function show($id)
    {
        // Find the RoleNavItem by ID
        $roleNavItem = RoleNavitem::find($id);

        if ($roleNavItem) {
            return response()->json(
                [
                    'success' => true,
                    'data' => $roleNavItem,
                    'message' => 'RoleNavItem fetched successfully'
                ]
            );
        }

        return response()->json(['message' => 'RoleNavItem not found'], 404);
    }

    /**
     * Update the specified role nav item in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'role_id' => 'sometimes|exists:roles,id',
            'nav_id' => 'sometimes|exists:navs,id',
        ]);

        // Find the RoleNavItem by ID
        $roleNavItem = RoleNavitem::find($id);

        if ($roleNavItem) {
            // Update RoleNavItem attributes
            $roleNavItem->update([
                'role_id' => $request->role_id ?? $roleNavItem->role_id,
                'nav_id' => $request->nav_id ?? $roleNavItem->nav_id,
            ]);

            return response()->json(
                [
                    'success' => true,
                    'data' => $roleNavItem,
                    'message' => 'RoleNavItem updated successfully'
                ]
            );
        }

        return response()->json(['message' => 'RoleNavItem not found'], 404);
    }

    /**
     * Remove the specified role nav item from storage.
     */
    public function destroy($id)
    {
        // Find the RoleNavItem by ID
        $roleNavItem = RoleNavitem::find($id);

        if ($roleNavItem) {
            $roleNavItem->delete();
            return response()->json(
                [
                    'success' => true,
                    'data' => $roleNavItem,
                    'message' => 'RoleNavItem deleted successfully'
                ]
            );
        }

        return response()->json(['message' => 'RoleNavItem not found'], 404);
    }
}
