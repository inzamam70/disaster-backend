<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{



    public function index($userId)
    {
       // find auth user fri=om local storage user
        $carts = Cart::where('user_id', $userId)
                     ->with('product','course')  // Load the related product data
                     ->get();
 
        return response()->json([
            'success' => true,
            'data' => $carts,
            'message' => 'Cart fetched successfully'
        ]);
    }


    


    public function create(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'course_id' => 'nullable|exists:courses,id',
            'quantity' => 'nullable|integer|min:1',
        ]);
    
        // Ensure at least one of product_id or course_id is present
        $hasProductId = $request->has('product_id') && !is_null($request->input('product_id'));
        $hasCourseId = $request->has('course_id') && !is_null($request->input('course_id'));
    
        if (!$hasProductId && !$hasCourseId) {
            return response()->json([
                'success' => false,
                'message' => 'Either product_id or course_id must be provided'
            ], 422);
        }
    
        $cart = Cart::where('user_id', $validated['user_id'])
            ->when($hasProductId, function ($query) use ($validated) {
                $query->where('product_id', $validated['product_id']);
            })
            ->when($hasCourseId, function ($query) use ($validated) {
                $query->where('course_id', $validated['course_id']);
            })
            ->first();
    
        if ($cart) {
            $cart->quantity += $validated['quantity'] ?? 1;
            $cart->save();
        } else {
            $cart = Cart::create([
                'user_id' => $validated['user_id'],
                'product_id' => $validated['product_id'] ?? null,
                'course_id' => $validated['course_id'] ?? null,
                'quantity' => $validated['quantity'] ?? 1,
            ]);
        }
    
        return response()->json([
            'success' => true,
            'data' => $cart,
            'message' => 'Item added to cart successfully'
        ]);
    }
    
    public function destroy($id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Cart not found'
        ], 404);
    }


    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $cart = Cart::find($id);

    if ($cart) {
        $cart->update($validated);
        return response()->json([
            'success' => true,
            'data' => $cart,
            'message' => 'Cart updated successfully'
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Cart not found'
    ], 404);
}

}
