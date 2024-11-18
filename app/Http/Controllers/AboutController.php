<?php

namespace App\Http\Controllers;

use App\Events\AboutCreated;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    //
    public function index()
    {
        $about = About::all();
        return response()->json([
            'success' => true,
            'data' => $about,
            'message' => 'About fetched successfully'
        ]);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'designation' => 'required|max:100',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'facebook' => 'nullable|string',
                'twitter' => 'nullable|string',
                'linkedin' => 'nullable|string',
                'instagram' => 'nullable|string',
            ]);
    
            $image = $request->file('image');
            $imgFileName = time() . '.' . $image->getClientOriginalExtension();
            $imgPath = 'images/about/' . $imgFileName;
    
            // Move the image to the appropriate folder
            $image->move(public_path('images/about'), $imgFileName);
    
            // Create and save the new entry
            $about = new About();
            $about->name = $validatedData['name'];
            $about->designation = $validatedData['designation'];
            $about->description = $validatedData['description'];
            $about->image = $imgPath;
            $about->facebook = $validatedData['facebook'] ?? '';
            $about->twitter = $validatedData['twitter'] ?? '';
            $about->linkedin = $validatedData['linkedin'] ?? '';
            $about->instagram = $validatedData['instagram'] ?? '';
            
            $about->save();

            event(new AboutCreated($about));

    
            return response()->json([
                'success' => true,
                'data' => $about,
                'message' => 'About created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating About: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function show(string $id)
    {
        $about = about::find($id);
        return response()->json([
            'success' => true,
            'data' => $about,
            'message' => 'About fetched successfully'
        ]);
    }

    public function update(Request $request, string $id)
    {
        $about = about::find($id);
        
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'description' => 'required',
            'image' => 'required',
            'facebook' => 'nullable|string',
            'twitter' => 'nullable|string',
            'linkedin' => 'nullable|string',
            'instagram' => 'nullable|string',
        ]);
    
        if ($request->hasFile('image')) {
            // Handle the new image upload
            $image = $request->file('image');
            $imgFileName = time() . '.' . $image->getClientOriginalExtension();
            $imgPath = 'images/about/' . $imgFileName;
            $image->move(public_path('images/about'), $imgPath);
            $about->image = $imgPath;
        }
        
        $about->name = $request->name;
        $about->designation = $request->designation;
        $about->description = $request->description;
        $about->facebook = $request->facebook;
        $about->twitter = $request->twitter;
        $about->linkedin = $request->linkedin;
        $about->instagram = $request->instagram;
        $about->save();
        
        return response()->json([
            'success' => true,
            'data' => $about,
            'message' => 'About updated successfully'
        ]);
    }

    public function destroy(string $id)
    {
        $about = about::find($id);
        $about->delete();
        return response()->json([
            'success' => true,
            'message' => 'About deleted successfully'
        ]);
    }
    
}
