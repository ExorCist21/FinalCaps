<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\Subscription;
use App\Models\Feedback;
use App\Models\SystemFeedbacks;
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
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $appointment = Appointment::findOrFail($appointmentID);

        $filePath = $request->file('proof')->store('proofs', 'public');

        // Create a new payment associated with the appointment
        Payment::create([
            'appointment_id' => $appointment->appointmentID,
            'amount' => $request->amount,
            'payment_method' => 'gcash',
            'transaction_id' => uniqid('tx_'),
            'status' => 'pending',
            'proof' => $filePath,
        ]);

        return back()->with('success', 'Payment proof sent. Waiting for admin approval.');
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
            case 'half_month':
                $patient->session_left += 15; // Standard subscription
                break;
            case 'month':
                $patient->session_left += 30; // Pro subscription
                break;
            case 'yearly':
                $patient->session_left += 365; // Enterprise subscription
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

    public function therapistFeedbacks()
    {
        $therapistFeedbacks = Feedback::with('patient','therapist')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.view_reports_therapist', compact('therapistFeedbacks'));
    }


    public function systemFeedbacks()
    {
        $systemFeedbacks = SystemFeedbacks::with('user') 
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.view_reports_system', compact('systemFeedbacks'));
    }

    public function therapistPayments()
    {
        $payments = Payment::with('appointment.therapist')->latest()->get();
        return view('admin.therapist-payments', compact('payments'));
    }

    public function confirmTherapistPayment($id)
    {
        $payment = Payment::findOrFail($id);
        
        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Payment already processed.');
        }

        $payment->status = 'confirmed';
        $payment->save();

        return redirect()->back()->with('success', 'Payment has been confirmed.');
    }
}
