<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        // Fetch all roles
        $roles = Role::all();
        return response()->json(
            [
                'success' => true,
                'data' => $roles,
                'message' => 'Roles fetched successfully'
            ]
        );
    }

    /**
     * Store a newly created role in storage.
     */
    public function create(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
        ]);

        // Create a new role
        $role = Role::create([
            'name' => $request->name,
        ]);

        return response()->json(
            [
                'success' => true,
                'data' => $role,
                'message' => 'Role created successfully'
            ],
             201); // Return newly created role
    }

    /**
     * Display the specified role.
     */
    public function show($id)
    {
        // Find the role by ID
        $role = Role::find($id);

        if ($role) {
            return response()->json(
                [
                    'success' => true,
                    'data' => $role,
                    'message' => 'Role fetched successfully'
                ]
            );
        }

        return response()->json(['message' => 'Role not found'], 404);
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'sometimes|string|max:255|unique:roles,name,' . $id,
        ]);

        // Find the role by ID
        $role = Role::find($id);

        if ($role) {
            // Update role attributes
            $role->update([
                'name' => $request->name ?? $role->name,
            ]);

            return response()->json(
                [
                    'success' => true,
                    'data' => $role,
                    'message' => 'Role updated successfully'
                ]
            );
        }

        return response()->json(['message' => 'Role not found'], 404);
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy($id)
    {
        // Find the role by ID
        $role = Role::find($id);

        if ($role) {
            $role->delete();
            return response()->json(
                [
                    'success' => true,
                    'data' => $role,
                    'message' => 'Role deleted successfully'
                ]
            );
        }

        return response()->json(['message' => 'Role not found'], 404);
    }
}
