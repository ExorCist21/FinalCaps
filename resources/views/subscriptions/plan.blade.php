<title>Plan</title>
<x-app-layout>
<div class="max-w-7xl mx-auto py-12">
    <h2 class="text-3xl font-bold text-center mb-8">MentalWell Subscription Plans</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Basic Plan -->
        <div class="border rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-xl font-bold text-center mb-4">Standard</h3>
            <p class="text-4xl font-bold text-center">₱500</p>
            <p class="text-center text-gray-500 mb-6">Every 3 months</p>
            <p class="text-center text-sm text-gray-600 mb-6">1 Therapist Session/Month</p>
            <ul class="mb-6 space-y-3">
                <li>✔️ Access to Therapists</li>
                <li>✔️ Chat Support</li>
                <li>✔️ Wellness Reports</li>
                <li>✔️ Mental Health Tips</li>
            </ul>
            <a href="{{ route('subscriptions.create', ['service_name' => 'Standard', 'price' => 500]) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg">Subscribe Now</a>
        </div>

        <!-- Pro Plan -->
        <div class="border rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-xl font-bold text-center mb-4">Pro</h3>
            <p class="text-4xl font-bold text-center">₱1,200</p>
            <p class="text-center text-gray-500 mb-6">Every 6 month</p>
            <p class="text-center text-sm text-gray-600 mb-6">4 Therapist Sessions/Month</p>
            <ul class="mb-6 space-y-3">
                <li>✔️ Everything in Standard</li>
                <li>✔️ Personalized Wellness Plan</li>
                <li>✔️ Priority Support</li>
                <li>✔️ Access to Workshops</li>
            </ul>
            <a href="{{ route('subscriptions.create', ['service_name' => 'Pro', 'price' => 1200]) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg">Subscribe Now</a>
        </div>

        <!-- Enterprise Plan -->
        <div class="border rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-xl font-bold text-center mb-4">Enterprise</h3>
            <p class="text-4xl font-bold text-center">₱5,000</p>
            <p class="text-center text-gray-500 mb-6">Custom Plan</p>
            <p class="text-center text-sm text-gray-600 mb-6">For Corporations or Institutions</p>
            <ul class="mb-6 space-y-3">
                <li>✔️ Everything in Pro</li>
                <li>✔️ Dedicated Therapist</li>
                <li>✔️ Custom Wellness Workshops</li>
                <li>✔️ Mental Health Analytics</li>
            </ul>
            <a href="{{ route('subscriptions.create', ['service_name' => 'Enterprise', 'price' => 5000]) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg">Subscribe Now</a>
        </div>
    </div>
</div>
</x-app-layout>
