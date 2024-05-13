<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    //
    public function index()
    {
        $contacts = Contact::all();

        return response()->json([
            'success' => true,
            'data' => $contacts,
            'message' => "Contact fetched successfully"
        ]);
    }

    public function create(Request $request)
    {
        $contact = Contact::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $contact,
            'message' => "Contact created successfully"
        ]);
    }

    public function show(string $id)
    {
        $contact = Contact::find($id);
        return response()->json([
            'success' => true,
            'data' => $contact,
            'message' => "Contact fetched successfully"
        ]);
    }

    public function update(Request $request, string $id)
    {
        $contact = Contact::find($id);
        $contact->update($request->all());
        return response()->json([
            'success' => true,
            'data' => $contact,
            'message' => "Contact updated successfully"
        ]);
    }

    public function destroy(string $id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return response()->json([
            'success' => true,
            'data' => $contact,
            'message' => "Contact deleted successfully"
        ]);
    }
}
