<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    //
    public function index()
    {
        $sliders = Slider::all();
        return response()->json([
            'success' => true,
            'data' => $sliders,
            'message' => 'Slider fetched successfully'
        ]);
    }

    // public function create(Request $request)
    // {
    //     $slider = Slider::create($request->all());
    //     return response()->json([
    //         'success' => true,
    //         'data' => $slider,
    //         'message' => 'Slider created successfully'
    //     ]);
    // }

    public function create(Request $request)
    {
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'short_title' => 'required|max:100',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $image = $request->file('image');
        $imgFileName = time() . '.' . $image->getClientOriginalExtension();
        $imgPath = 'images/sliders/' . $imgFileName;
    
        // Move the image to the appropriate folder
        $image->move(public_path('images/sliders'), $imgFileName);
    
        // Create and save the new slider
        $slider = new Slider();
        $slider->title = $validatedData['title'];
        $slider->short_title = $validatedData['short_title'];
        $slider->description = $validatedData['description'];
        $slider->image = $imgPath;
        $slider->save();
        return response()->json([
              'success' => true,
                'data' => $slider,
                'message' => 'Slider created successfully'
           ]);
    }

    public function show(string $id)
    {
        $slider = Slider::find($id);
        return response()->json([
            'success' => true,
            'data' => $slider,
            'message' => 'Slider fetched successfully'
        ]);
    }
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('sliders.edit', compact('slider'));
    }

    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required|max:255',
    //         'short_title' => 'required|max:100',
    //         'description' => 'required',
    //         'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);
    
    //     $slider = Slider::findOrFail($id);
    
    //     $slider->title = $validatedData['title'];
    //     $slider->short_title = $validatedData['short_title'];
    //     $slider->description = $validatedData['description'];
    
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('sliders');
    //         $slider->image = $imagePath;
    //     }
    
    //     $slider->save();
    
    //     return response()->json([
    //         'success' => true,
    //           'data' => $slider,
    //           'message' => 'Slider update successfully'
    //      ]);
    // }

    public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'short_title' => 'required|max:100',
        'description' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $slider = Slider::findOrFail($id);

    // Update the text fields
    $slider->title = $validatedData['title'];
    $slider->short_title = $validatedData['short_title'];
    $slider->description = $validatedData['description'];

    // Handle the image update
    if ($request->hasFile('image')) {
        // Remove the old image if it exists
        if (file_exists(public_path($slider->image))) {
            unlink(public_path($slider->image));
        }

        // Save the new image
        $image = $request->file('image');
        $imgFileName = time() . '.' . $image->getClientOriginalExtension();
        $imgPath = 'images/sliders/' . $imgFileName;
        $image->move(public_path('images/sliders'), $imgFileName);

        // Update the image path in the database
        $slider->image = $imgPath;
    }

    // Save the updated slider record
    $slider->save();

    return response()->json([
        'success' => true,
        'data' => $slider,
        'message' => 'Slider updated successfully'
    ]);
}


    public function destroy( $id)
    {
        $slider = Slider::find($id);
        $slider->delete();
        return response()->json([
            'success' => true,
            'data' => $slider,
            'message' => 'Slider deleted successfully'
        ]);
    }
}
