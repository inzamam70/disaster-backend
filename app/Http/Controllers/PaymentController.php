<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //

    public function index($userId)
    {
        $payments = Payment::with('user')->where('user_id', $userId)
            ->with('product', 'course') // Assuming both can exist
            ->get();

        return response()->json([
            'success' => true,
            'data' => $payments,
            'message' => 'Payments fetched successfully'
        ]);
    }

    public function alldata()
    {
        $payments = Payment::with('user')->get();

        return response()->json([
            'success' => true,
            'data' => $payments,
            'message' => 'Payments fetched successfully'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'nullable|exists:products,id',
            'course_id' => 'nullable|exists:courses,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'phone' => 'required|string|max:15',
            'transaction_id' => 'required|string|max:255',
            'payment_method' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
        ]);

        $payment = Payment::create($validated);

        return response()->json([
            'success' => true,
            'data' => $payment,
            'message' => 'Payment created successfully'
        ]);
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $payment,
            'message' => 'Payment fetched successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'product_id' => 'sometimes|exists:products,id',
            'course_id' => 'sometimes|exists:courses,id',
            'title' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'quantity' => 'sometimes|integer|min:1',
            'total_amount' => 'sometimes|numeric|min:0',
            'phone' => 'sometimes|string|max:15',
            'transaction_id' => 'sometimes|string|max:255',
            'payment_method' => 'sometimes|string|max:50',
            'payment_status' => 'sometimes|string|max:50',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update($validated);

        return response()->json([
            'success' => true,
            'data' => $payment,
            'message' => 'Payment updated successfully'
        ]);
    }
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,accepted,denied',
        ]);

        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['success' => false, 'message' => 'Payment not found'], 404);
        }

        $payment->payment_status = $request->payment_status;
        $payment->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
}
