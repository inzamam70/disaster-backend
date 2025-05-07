<?php

namespace App\Http\Controllers;

use App\Http\Resources\LandingCard\LandinCardCollection;
use App\Http\Resources\LandingCard\LandinCardResource;
use App\Models\Landingcard;
use Illuminate\Http\Request;

class LandingcardController extends Controller
{
    //
    public function index()
    {

        $landingcards = Landingcard::all(); 
        return response()->json([
            'success' => true,
            'data' => LandinCardResource::collection($landingcards),
            'message' => 'Landingcard fetched successfully'
        ]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'required',
            'affectedtype_id' => 'required|exists:affected_types,id',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $image = $request->file('image');
        $imgFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $imgPath = 'images/landingcards/' . $imgFileName;
        $image->move(public_path('images/landingcards'), $imgPath);

        $landingcard = new Landingcard();
        $landingcard->title = $validatedData['title'];
        $landingcard->description = $validatedData['description'];
        $landingcard->affectedtype_id = $validatedData['affectedtype_id'];
        $landingcard->latitude = $validatedData['latitude'];
        $landingcard->longitude = $validatedData['longitude'];
        $landingcard->image = $imgPath;
        $landingcard->save();

        return response()->json([
            'success' => true,
            'data' => $landingcard,
            'message' => 'Landingcard created successfully'
        ]);
    }

    public function show(string $id)
    {
        $landingcard = Landingcard::find($id);
        return response()->json([
            'success' => true,
            'data' => $landingcard,
            'message' => 'Landingcard fetched successfully'
        ]);
    }

    public function update(Request $request, string $id)
    {
        $landingcard = Landingcard::find($id);
        $landingcard->update($request->all());
        return response()->json([
            'success' => true,
            'data' => $landingcard,
            'message' => 'Landingcard updated successfully'
        ]);
    }

    public function destroy(string $id)
    {
        $landingcard = Landingcard::find($id);
        $landingcard->delete();
        return response()->json([
            'success' => true,
            'message' => 'Landingcard deleted successfully'
        ]);
    }
    
}
