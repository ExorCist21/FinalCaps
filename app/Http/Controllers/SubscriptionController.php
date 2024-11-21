<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Payment;
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
            'service_name' => 'required|string|max:255',
            'duration' => 'required|integer|in:2,5,10', // Validate duration
            'payment_method' => 'required|string|in:gcash,maya,credit_card,paypal',
            'price' => 'required|numeric|min:1|max:10000',
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
            'duration' => 'required|integer|in:3,6,12', // Validate duration
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

        return redirect('/patient/subscriptions')->with('success', 'Subscription canceled successfully.');
    }

    public function approvePayment($subscriptionId)
    {
        // Find the subscription by ID
        $subscription = Subscription::findOrFail($subscriptionId);

        if ($subscription->status === 'pending') {
            // Update the subscription status to 'active'
            $subscription->status = 'active';
            $subscription->save();

            // Approve the payment if you have a Payment model related to the subscription
            $payment = Payment::where('subscription_id', $subscriptionId)->first();
            if ($payment && $payment->status === 'pending') {
                $payment->status = 'approved';
                $payment->save();
            }

            $user = User::findOrFail($subscription->patient_id); 

            // Increment session_left based on the service_name
            switch ($subscription->service_name) {
                case 'Standard':
                    $user->session_left += 2; // Add 2 sessions for Standard
                    break;
                case 'Pro':
                    $user->session_left += 5; // Add 5 sessions for Pro
                    break;
                case 'Enterprise':
                    $user->session_left += 10; // Add 10 sessions for Enterprise
                    break;
                default:
                    return redirect()->back()->with('error', 'Unknown service name.');
            }

            // Save the updated user data
            $user->save();

            return redirect()->back()->with('success', 'Payment, subscription approved, and sessions added successfully.');
        }

        return redirect()->back()->with('error', 'Subscription not found or already processed.');
    }
}