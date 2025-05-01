<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SubscriptionController extends Controller
{
    // List all subscriptions
    public function index()
    {
        $subscriptions = Subscription::where('patient_id', auth()->id())->get(); // Assuming 'user_id' is the foreign key
        return view('subscriptions.index', compact('subscriptions'));
    }

    public function pendingPayments()
    {
        // Eager load the 'payment' relationship to reduce queries
        $subscriptions = Subscription::with('payment')->where('status', 'pending')->get();
        return view('admin.pending', compact('subscriptions'));
    }


    // Show form to subscribe to a service
    public function create()
    {
        return view('subscriptions.create');
    }

    public function subPlan() {
        return view('subscriptions.plan');
    }

    public function payment(Request $request)
    {
        $subscription_id = $request->query('subscription_id');
        $price = $request->query('price');
        $payment_method = $request->query('payment_method');

        // Pass these variables to the view
        return view('subscriptions.payment', compact('subscription_id', 'price', 'payment_method'));
    }

    // Store a new subscription
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'service_name' => 'required|string|in:half_month,month,yearly',
            'duration' => 'required|integer|in:15,30,365',
            'payment_method' => 'required|string|in:gcash,maya,credit_card,paypal',
            'price' => 'required|numeric|min:1|max:20000',
        ]);

        // Create the subscription
        $subscription = Subscription::create([
            'service_name' => $validated['service_name'],
            'duration' => $validated['duration'], // Save duration
            'patient_id' => auth()->id(),
            'status' => 'pending', // Set initial status
        ]);

        // Create the payment record
        Payment::create([
            'subscription_id' => $subscription->id,
            'amount' => $validated['price'],
            'payment_method' => $validated['payment_method'],
            'transaction_id' => null, // Placeholder for now
            'status' => 'pending',
            'proof' => null,
        ]);

        // Redirect to payment page
        return redirect()->route('subscriptions.payment', [
            'subscription_id' => $subscription->id,
            'price' => $validated['price'],
            'payment_method' => $validated['payment_method'],
        ])->with('success', 'Subscription created successfully. Proceed to payment.');
    }

    // Show form to edit a subscription
    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('subscriptions.edit', compact('subscription'));
    }

    // Update an existing subscription
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'duration' => 'required|integer|in:1,2,5', // Validate duration
        ]);

        $subscription = Subscription::findOrFail($id);
        $subscription->update($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription updated successfully.');
    }
    
    // Cancel/Delete a subscription
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect('/therapist/subscriptions')->with('success', 'Subscription canceled successfully.');
    }

    // Location: App\Http\Controllers\AdminController.php

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
        $user = User::find($subscription->patient_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Add sessions based on service name
        switch ($subscription->service_name) {
            case 'half_month':
                $user->session_left += 15;
                break;
            case 'month':
                $user->session_left += 30;
                break;
            case 'yearly':
                $user->session_left += 365;
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

        $admin->total_revenue += $payment->amount; // Add payment amount to admin's total revenue
        $admin->save();

        // Create notification for the patient
        Notification::create([
            'n_userID' => $patient->id,
            'type' => 'approve_payment',
            'data' => 'Your subscription has been approved by the admin.',
        ]);

        return redirect()->back()->with('success', 'Payment, subscription approved, and sessions added successfully.');
    }

    public function lock() {
        $subscriptions = Subscription::where('patient_id', auth()->id())->get();
        return view('subscriptions.index', compact('subscriptions'));
    }

}