<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        return view('admin.users');
    }

    public function reports()
    {
        return view('admin.reports');
    }
    
    public function therapists()
    {
        $therapists = User::where('role', 'therapist')
        ->with('therapistInformation')->get();
        
        // Assuming 'role' column holds user roles
        return view('admin.therapist', compact('therapists'));
    }

    public function patients()
    {
        $patients = User::where('role', 'patient')->get(); // Assuming 'role' column holds user roles
        return view('admin.patient', compact('patients'));
    }

    public function selectRegister() {
        return view ('select-register');
    }

    public function showAppointments()
    {
        $appointments = Appointment::with([
            'progress' => function($query) {
                $query->where('status', 'Completed'); // Only fetch progress with 'Completed' status
            },
            'therapist.therapistInformation',
            'payments'
        ])
        ->get();

        // Passing the appointments as is and adding the logic to access completed progress directly in the view
        return view('admin.payment-management', compact('appointments'));
    }

    public function showPaymentForm($appointmentID)
    {
        // Fetch the appointment along with its related therapist and progress records
        $appointment = Appointment::with('therapist', 'progress')->findOrFail($appointmentID);
        
        // Check if there's a progress with status 'Completed'
        $completedProgress = $appointment->progress->firstWhere('status', 'Completed');

        // Only show the payment form if a 'Completed' progress exists
        if (!$completedProgress) {
            return redirect()->back()->with('error', 'Payment can only be made for completed progress.');
        }

        return view('admin.send-payment', compact('appointment'));
    }

    // app/Http/Controllers/AdminController.php

    public function sendPayment(Request $request, $appointmentID)
    {
        // Validate the input fields
        $validated = $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate payment proof image
            'amount' => 'required|numeric|min:1', // Validate the payment amount
            'payment_method' => 'required|string|max:255', // Payment method (e.g., GCash)
        ]);

        // Fetch the appointment and therapist information
        $appointment = Appointment::with('therapist', 'progress')->findOrFail($appointmentID);
        $therapistInformation = $appointment->therapist->therapistInformation;

        // Check if the therapist has a GCash number
        if (!$therapistInformation || !$therapistInformation->gcash_number) {
            return redirect()->back()->with('error', 'Therapist does not have a GCash number.');
        }

        // Store the payment proof image
        $paymentProofPath = $request->file('payment_proof')->store('proofs', 'public');

        // Create a new payment record
        $payment = new Payment();

        // Check if the appointment has a related subscription; if not, set to null
        $payment->subscription_id = $appointment->subscription_id ?? null;

        $payment->amount = $validated['amount'];
        $payment->proof = $paymentProofPath;
        $payment->payment_method = $validated['payment_method'];
        $payment->transaction_id = $appointment->appointmentID; // Generate a unique transaction ID or set it dynamically
        $payment->status = 'Pending'; // Initially, status can be 'Pending' until processed
        $payment->save();

        return redirect()->route('admin.appointments', ['appointmentID' => $appointmentID])
            ->with('success', 'Payment sent and proof uploaded successfully.');
    }

}
