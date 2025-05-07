<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //

    public function index()
    {
        $activities = Activity::all();

        return response()->json([
            'success' => true,
            'data' => $activities,
            'message' => 'Activities fetched successfully'
        ]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'tag' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required',
        ]);

        $image = $request->file('image');
        $imgFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $imgPath = 'images/activities/' . $imgFileName;
        $image->move(public_path('images/activities'), $imgPath);

        $activity = new Activity();
        $activity->tag = $validatedData['tag'];
        $activity->title = $validatedData['title'];
        $activity->description = $validatedData['description'];
        $activity->image = $imgPath;
        $activity->save();

        return response()->json([
            'success' => true,
            'data' => $activity,
            'message' => 'Activity created successfully'
        ]);
    }

    public function show(string $id)
    {
        $activity = Activity::find($id);
        return response()->json([
            'success' => true,
            'data' => $activity,
            'message' => 'Activity fetched successfully'
        ]);
    }

    public function update(Request $request, string $id)
    {
       $activity = Activity::find($id);
       $activity->update($request->all());
       return response()->json([
            'success' => true,
            'data' => $activity,
            'message' => 'Activity updated successfully'
        ]);
    }

    public function destroy(string $id)
    {
        $activity = Activity::find($id);
        $activity->delete();

        return response()->json([
            'success' => true,
            'message' => 'Activity deleted successfully'
        ]);
    }
    
}
