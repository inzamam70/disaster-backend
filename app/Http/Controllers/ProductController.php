<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => "Products fetched successfully"
        ]);
    }
    
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgFileName = time() . '.' . $image->getClientOriginalExtension();
            $imgPath = 'images/products/' . $imgFileName;
            $image->move(public_path('images/products'), $imgFileName);
        } else {
            $imgPath = null;
        }

        $product = new Product();
        $product->title = $validatedData['title'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->image = $imgPath;
        $product->save();

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => "Product created successfully"
        ]);
    }
    public function show(string $id)
    {
        $product = Product::find($id);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => "Product fetched successfully"
        ]);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => "Product not found"
            ], 404);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imgFileName = time() . '.' . $image->getClientOriginalExtension();
            $imgPath = 'images/products/' . $imgFileName;
            $image->move(public_path('images/products'), $imgFileName);
        } else {
            $imgPath = null;
        }

        $product->title = $validatedData['title'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        if ($imgPath) {
            $product->image = $imgPath;
        }
        $product->save();

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => "Product updated successfully"
        ]);
    }
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => "Product not found"
            ], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => "Product deleted successfully"
        ]);
    }
}
