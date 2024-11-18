<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    public function index()
    {
        // Fetch messages along with user data
        $messages = Message::with('user')->get();
    
        return response()->json([
            'success' => true,
            'data' => $messages, // This will include user data since we're eager-loading 'user'
            'message' => "Message fetched successfully"
        ]);
    }
    

    public function sendMassage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id' // Ensure user ID is valid
        ]);
    
        // Create the message and associate it with the user
        $message = new Message();
        $message->message = $request->message;
        $message->user_id = $request->user_id; // Use the provided user_id
        $message->save();
    
        broadcast(new MessageSent($message));
    
        return response()->json([
            'success' => true,
            'data' => $message,
            'message' => "Message sent successfully"
        ]);
    }
    
    
    
}
