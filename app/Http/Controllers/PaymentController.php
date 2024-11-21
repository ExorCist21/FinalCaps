<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request input
        $validated = $request->validate([
            'subscription_id' => 'required|exists:payments,subscription_id',
            'proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
        ]);

        // Find the payment record based on subscription ID
        $payment = Payment::where('subscription_id', $validated['subscription_id'])->firstOrFail();

        // Handle the image upload
        if ($request->hasFile('proof')) {
            // Store the image in the 'proofs' directory inside the storage/app/public directory
            $path = $request->file('proof')->store('proofs', 'public');
            
            // Generate the public URL for the file (making sure it's publicly accessible)
            $proofUrl = Storage::url($path); // This generates a public URL
    
            // Save the URL of the file in the database
            $payment->proof = $proofUrl; // Save URL to database
            $payment->status = 'pending'; // Set status to pending until admin approval
            $payment->save();
        }

        
        return redirect('/patient/subscriptions')->with('success', 'Payment proof uploaded successfully. Awaiting admin approval.');
    }
}
