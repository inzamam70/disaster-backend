<?php

namespace App\Http\Controllers;

use App\Models\TrainingCenter;
use Illuminate\Http\Request;

class TrainingCenterController extends Controller
{
    //

    public function index()
    {
        $centers = TrainingCenter::all();

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
            'description' => 'required',
            'opening_hours' => 'required|date_format:H:i',
            'closing_hours' => 'required|date_format:H:i',
            'center_type' => 'required|max:255',
            'image' => 'required|image'
        ]);

        $image = $request->file('image');
        $imgFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $imgPath = 'images/centers/' . $imgFileName;
        $image->move(public_path('images/centers'), $imgPath);

        $center = new TrainingCenter();
        $center->title = $validatedData['title'];
        $center->location = $validatedData['location'];
        $center->description = $validatedData['description'];
        $center->opening_hours = $validatedData['opening_hours'];
        $center->closing_hours = $validatedData['closing_hours'];
        $center->center_type = $validatedData['center_type'];
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
        $center = TrainingCenter::find($id);
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
            'description' => 'required',
            'opening_hours' => 'required|date_format:H:i',
            'closing_hours' => 'required|date_format:H:i',
            'center_type' => 'required|max:255',
            'image' => 'image'
        ]);

        $center = TrainingCenter::find($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $imgPath = 'images/centers/' . $imgFileName;
            $image->move(public_path('images/centers'), $imgPath);
            $center->image = $imgPath;
        }

        $center->title = $validatedData['title'];
        $center->location = $validatedData['location'];
        $center->description = $validatedData['description'];
        $center->opening_hours = $validatedData['opening_hours'];
        $center->closing_hours = $validatedData['closing_hours'];
        $center->center_type = $validatedData['center_type'];
        $center->save();

        return response()->json([
            'success' => true,
            'data' => $center,
            'message' => "Center updated successfully"
        ]);
    }
    public function destroy(string $id)
    {
        $center = TrainingCenter::find($id);
        if ($center) {
            $center->delete();
            return response()->json([
                'success' => true,
                'message' => "Center deleted successfully"
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Center not found"
            ], 404);
        }
    }
}
