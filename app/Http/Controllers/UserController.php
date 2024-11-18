<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all users
        $users = User::with('activeRole')->get();
       
        $totalUser = count($users->where('active_role_id', 2));
        $totalVolunteer = count($users->where('active_role_id', 3));

        return response()->json(
            [
                'success' => true,
                'data' => $users,
                'totalUser' => $totalUser,
                'totalVolunteer' => $totalVolunteer,
                'message' => 'Users fetched successfully'
            ]
        );
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password
            'active_role_id' => $request->active_role_id ?? 4, // Hash password
        ]);

        return response()->json(
            [
                'success' => true,
                'data' => $user,
                'message' => 'User created successfully'
            ],
             201); // Return newly created user
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if ($user) {
            return response()->json(
                [
                    'success' => true,
                    'data' => $user,
                    'message' => 'User fetched successfully'
                ]
            );
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        // Find the user by ID
        $user = User::find($id);

        if ($user) {
            // Update user attributes
            $user->update([
                'name' => $request->name ?? $user->name,
                'email' => $request->email ?? $user->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            return response()->json(
                [
                    'success' => true,
                    'data' => $user,
                    'message' => 'User updated successfully'
                ]
            );
        }

        return response()->json(['message' => 'User not found'], 404);


    }
    
    public function assignRole(Request $request, $id)
    {

        // Validate incoming request
        $request->validate([
            'role_id' => 'required',
        ]);

        // Find the user by ID
        $user = User::find($id);


        if ($user) {
            // Assign role to user
            $user->active_role_id = $request->role_id;
            $user->save();

            return response()->json(
                [
                    'success' => true,
                    'data' => $user,
                    'message' => 'Role assigned successfully'
                ]
            );
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the user by ID
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(
                [
                    'success' => true,
                    'data' => $user,
                    'message' => 'User deleted successfully'
                ]
            );
        }

        return response()->json(
            [
                'success' => false,
                'message' => 'User not found'
            ]
            , 404);
    }
}
