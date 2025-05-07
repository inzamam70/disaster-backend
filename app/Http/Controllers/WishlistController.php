<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // public function index()
    // {
    //     $wishlists = Wishlist::with('product')->get();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $wishlists,
    //         'message' => 'Wishlist fetched successfully'
    //     ]);
    // }
    public function index($userId)
    {
        $wishlist = Wishlist::where('user_id', $userId)
            ->with('product', 'course') // Assuming both can exist
            ->get();
    
        return response()->json([
            'success' => true,
            'data' => $wishlist,
            'message' => 'Wishlist fetched successfully'
        ]);
    }


    // public function create(Request $request)
    // {
    //     $wishlist = Wishlist::create($request->all());
    
    //     return response()->json([
    //         'success' => true,
    //         'data' => $wishlist,
    //         'message' => 'Product added to wishlist successfully'
    //     ]);
    // }

    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'product_id' => 'nullable|exists:products,id',
        'course_id' => 'nullable|exists:courses,id',
    ]);

    $hasProductId = $request->has('product_id') && !is_null($request->input('product_id'));
    $hasCourseId = $request->has('course_id') && !is_null($request->input('course_id'));

    if (!$hasProductId && !$hasCourseId) {
        return response()->json(['success' => false, 'message' => 'Either product_id or course_id must be provided'], 422);
    }

    $exists = Wishlist::where('user_id', $validated['user_id'])
        ->when($hasProductId, fn($q) => $q->where('product_id', $validated['product_id']))
        ->when($hasCourseId, fn($q) => $q->where('course_id', $validated['course_id']))
        ->first();

    if ($exists) {
        return response()->json(['success' => false, 'message' => 'Already in wishlist']);
    }

    $wishlist = Wishlist::create([
        'user_id' => $validated['user_id'],
        'product_id' => $validated['product_id'] ?? null,
        'course_id' => $validated['course_id'] ?? null,
    ]);

    return response()->json(['success' => true, 'data' => $wishlist, 'message' => 'Item added to wishlist']);
}

    

    // public function destroy($id)
    // {
    //     $wishlist = Wishlist::find($id);
    //     if ($wishlist) {
    //         $wishlist->delete();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Product removed from wishlist successfully'
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Wishlist not found'
    //     ], 404);
    // }

    public function destroy($id)
{
    $wishlist = Wishlist::find($id);
    if ($wishlist) {
        $wishlist->delete();
        return response()->json(['success' => true, 'message' => 'Item removed from wishlist']);
    }

    return response()->json(['success' => false, 'message' => 'Item not found'], 404);
}

    public function show($id)
    {
        $wishlist = Wishlist::find($id);
        if ($wishlist) {
            return response()->json([
                'success' => true,
                'data' => $wishlist,
                'message' => 'Wishlist fetched successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Wishlist not found'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $wishlist = Wishlist::find($id);
        if ($wishlist) {
            $wishlist->update($request->all());
            return response()->json([
                'success' => true,
                'data' => $wishlist,
                'message' => 'Wishlist updated successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Wishlist not found'
        ], 404);
    }
    
}
