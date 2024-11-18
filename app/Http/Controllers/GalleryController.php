<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    //
    public function index()
    {   
        $gallery = Gallery::all();
        return response()->json([
            'success' => true,
            'data' => $gallery,
            'message' => 'Gallery fetched successfully'
        ]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required',
        ]);

        $image = $request->file('image');
        $imgFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $imgPath = 'images/gallery/' . $imgFileName;
        $image->move(public_path('images/gallery'), $imgPath);

        $gallery = new Gallery();
        $gallery->image = $imgPath;
        $gallery->save();

        return response()->json([
            'success' => true,
            'data' => $gallery,
            'message' => 'Gallery created successfully'
        ]);
    }

    public function show(string $id)
    {
        $gallery = Gallery::find($id);
        return response()->json([
            'success' => true,
            'data' => $gallery,
            'message' => 'Gallery fetched successfully'
        ]);
    }

    public function update(Request $request, string $id)
    {
        $gallery = Gallery::find($id);
        
        // Validate the request
        $validatedData = $request->validate([
            'image' => 'nullable|image', // Make image nullable
        ]);
    
        if ($request->hasFile('image')) {
            // Handle the new image upload
            $image = $request->file('image');
            $imgFileName = time() . '.' . $image->getClientOriginalExtension();
            $imgPath = 'images/gallery/' . $imgFileName;
            $image->move(public_path('images/gallery'), $imgPath);
            
            // Update the image path in the gallery
            $gallery->image = $imgPath;
        }
        
        $gallery->save(); // Save changes
        
        return response()->json([
            'success' => true,
            'data' => $gallery,
            'message' => 'Gallery updated successfully'
        ]);
    }
    

    public function destroy(string $id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();

        return response()->json([
            'success' => true,
            'data' => $gallery,
            'message' => 'Gallery deleted successfully'
        ]);
    }


}
