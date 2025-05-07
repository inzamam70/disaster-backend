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
    // public function create(Request $request)
    // {
    //     // Validate incoming request
    //     $request->validate([
    //         'roleId' => 'required|exists:roles,id',
    //         'navItemIds' => 'required|array', // Ensure navItemIds is an array
    //         'navItemIds.*' => 'exists:navs,id', // Each item in the array must exist in navs table
    //     ]);
    
    //     $roleId = $request->roleId;
    //     $navItemIds = $request->navItemIds;
    
    //     // Store each nav item with the role
    //     $roleNavItems = [];
    //     foreach ($navItemIds as $navId) {
    //         $roleNavItems[] = RoleNavitem::create([
    //             'role_id' => $roleId,
    //             'nav_id' => $navId,
    //         ]);
    //     }
    
    //     return response()->json(
    //         [
    //             'success' => true,
    //             'data' => $roleNavItems,
    //             'message' => 'RoleNavItems created successfully',
    //         ],
    //         201
    //     ); // Return newly created RoleNavItems
    // }
    
    public function create(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'roleId' => 'required|exists:roles,id',
            'navItemIds' => 'required|array',
            'navItemIds.*' => 'exists:navs,id',
        ]);
    
        $roleId = $request->roleId;
        $navItemIds = $request->navItemIds;
    
        // Get the current nav items associated with this role
        $existingNavItems = RoleNavitem::where('role_id', $roleId)->pluck('nav_id')->toArray();
    
        // Filter out already existing nav items that are selected
        $newNavItemIds = array_diff($navItemIds, $existingNavItems);
    
        // Store the new nav items for this role
        $roleNavItems = [];
        foreach ($newNavItemIds as $navId) {
            $roleNavItems[] = RoleNavitem::create([
                'role_id' => $roleId,
                'nav_id' => $navId,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'data' => $roleNavItems,
            'message' => 'RoleNavItems updated successfully',
        ], 201);
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

    public function userRoleNavItems($roleId)
    {
       
        $navItems = RoleNavitem::where('role_id', $roleId)->with('nav')->get();

        return response()->json(
            [
                'success' => true,
                'data' => $navItems,
                'message' => 'User role nav items fetched successfully'
            ]
        );
    }
}
