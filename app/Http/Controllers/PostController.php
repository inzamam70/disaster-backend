<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function index()
    {
        $posts = Post::with(['user', 'affectedType'])->get();


        return response()->json([
            'success' => true,
            'data' => $posts,
            'message' => "Posts fetched successfully"
        ]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'affectedtype_id' => 'required|exists:affected_types,id',
        ]);
    
        $image = $request->file('image');
        $imgFileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $imgPath = 'images/posts/' . $imgFileName;
        $image->move(public_path('images/posts'), $imgPath);
        $post = new Post();
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->user_id = $validatedData['user_id'];
        $post->affectedtype_id = $validatedData['affectedtype_id'];
        $post->image = $imgPath;
        $post->save();
        
        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => "Post created successfully"
        ]);
    }
    
    public function show(string $id)
    {
        $post = Post::find($id);

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => "Post fetched successfully"
        ]);
    }

    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => "Post updated successfully"
        ]);
    }

    public function delete(string $id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => "Post deleted successfully"
        ]);
    }

}
