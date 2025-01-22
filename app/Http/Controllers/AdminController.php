<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\Subscription;
use App\Models\Notification;

class AdminController extends Controller
{
    public function index()
    {
        // Get the total number of users
        $totalUsers = User::count();

        // Get the number of active users
        $activeUsers = User::where('isActive', 1)->count();

        // Get the number of inactive users
        $inactiveUsers = User::where('isActive', 0)->count();

        // Get the most recent users
        $recentUsers = User::latest()->take(5)->get();

        // Pass the data to the view
        return view('admin.dashboard', compact('totalUsers', 'activeUsers', 'inactiveUsers', 'recentUsers'));
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

    // Send Payment method to process the payment and upload proof
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

    // Approve payment and update subscription and patient data
    public function approvePayment($subscriptionId)
    {
        // Find the subscription
        $subscription = Subscription::findOrFail($subscriptionId);

        if ($subscription->status !== 'pending') {
            return redirect()->back()->with('error', 'Subscription not found or already processed.');
        }

        // Update subscription status
        $subscription->status = 'active';
        $subscription->save();

        // Find related payment
        $payment = Payment::where('subscription_id', $subscriptionId)->first();
        if (!$payment || $payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Payment record not found or already approved.');
        }

        // Approve payment
        $payment->status = 'approved';
        $payment->save();

        // Find the patient
        $patient = User::find($subscription->patient_id);
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }

        // Add sessions based on service name
        switch ($subscription->service_name) {
            case 'Standard':
                $patient->session_left += 1; // Standard subscription
                break;
            case 'Pro':
                $patient->session_left += 5; // Pro subscription
                break;
            case 'Enterprise':
                $patient->session_left += 2; // Enterprise subscription
                break;
            default:
                return redirect()->back()->with('error', 'Unknown service name.');
        }

        // Save patient data
        $patient->save();

        // Update admin's total revenue
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            return redirect()->back()->with('error', 'Admin not found.');
        }

        // Increment the admin's total revenue by the payment amount
        $admin->total_revenue += $payment->amount;
        $admin->save();

        // Create notification for the patient
        Notification::create([
            'n_userID' => $patient->id,
            'type' => 'approve_payment',
            'data' => 'Your subscription has been approved by the admin.',
        ]);

        return redirect()->back()->with('success', 'Payment, subscription approved, and sessions added successfully.');
    }
}
