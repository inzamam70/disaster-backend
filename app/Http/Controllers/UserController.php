<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'success' => true,
            'data' => $users,
            'message' => "User fetched successfully"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $password = bcrypt($request->password);
        $request->merge(['password'=>$password]);
        $user = User::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => "User registered successfully"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
       


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => "User fetched successfully"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::find($id);
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => "User fetched successfully"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);
        $user->update($request->all());
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => "User updated successfully"
        ],200);

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        $user->delete();
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => "User deleted successfully"
        ]);
    }
}
