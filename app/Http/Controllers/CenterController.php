<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    //
    public function index()
    {
        $centers = Center::all();

        return response()->json([
            'success' => true,
            'data' => $centers,
            'message' => "Centers fetched successfully"
        ]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'location' => 'required|max:255',
            'capacity' => 'required|integer',
            'image' => 'required|image'
        ]);

        $image = $request->file('image');
        $imgFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $imgPath = 'images/centers/' . $imgFileName;
        $image->move(public_path('images/centers'), $imgPath);

        $center = new Center();
        $center->title = $validatedData['title'];
        $center->location = $validatedData['location'];
        $center->capacity = $validatedData['capacity'];
        $center->image = $imgPath;
        $center->save();

        return response()->json([
            'success' => true,
            'data' => $center,
            'message' => "Center created successfully"
        ]);
    }
    public function show(string $id)
    {
        $center = Center::find($id);
        return response()->json([
            'success' => true,
            'data' => $center,
            'message' => "Center fetched successfully"
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'location' => 'required|max:255',
            'capacity' => 'required|integer',
            'image' => 'image'
        ]);

        $center = Center::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $imgPath = 'images/centers/' . $imgFileName;
            $image->move(public_path('images/centers'), $imgPath);
            $center->image = $imgPath;
        }

        $center->title = $validatedData['title'];
        $center->location = $validatedData['location'];
        $center->capacity = $validatedData['capacity'];
        $center->save();

        return response()->json([
            'success' => true,
            'data' => $center,
            'message' => "Center updated successfully"
        ]);
    }

    public function destroy(string $id)
    {
        $center = Center::find($id);
        $center->delete();
        return response()->json([
            'success' => true,
            'data' => $center,
            'message' => "Center deleted successfully"
        ]);
    }


    
}
