<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //

    public function index()
    {
        $cources = Course::all();

        return response()->json([
            'success' => true,
            'data' => $cources,
            'message' => "Courses fetched successfully"
        ]);
    }

    public function create(Request $request){

        $course = Course::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $course,
            'message' => "course created successfully"
        ]);
    }

    
    public function show(string $id)
    {
        $course = Course::find($id);

        return response()->json([
            'success' => true,
            'data' => $course,
            'message' => "course fetched successfully"
        ]);
    }

    public function update(Request $request, string $id)
    {
        $course = Course::find($id);
        $course->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $course,

            'message' => "course updated successfully"
        ]);
    }

    public function destroy(string $id)
    {
        $course = Course::find($id);
        $course->delete();

        return response()->json([
            'success' => true,
            'message' => "course deleted successfully"
        ]);
    }
}
