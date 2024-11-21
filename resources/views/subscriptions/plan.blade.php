<title>Plan</title>
<x-app-layout>
<div class="max-w-7xl mx-auto py-12">
    <h2 class="text-3xl font-bold text-center mb-8">MentalWell Session Plans</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Basic Plan -->
        <div class="border rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-xl font-bold text-center mb-4">Standard</h3>
            <p class="text-4xl font-bold text-center">₱500</p>
            <p class="text-center text-sm text-gray-600 mb-6">+ 2 Therapist Session</p>
            <ul class="mb-6 space-y-3">
                <li>✔️ Access to Therapists</li>
                <li>✔️ Chat Support</li>
                <li>✔️ Wellness Reports</li>
                <li>✔️ Mental Health Tips</li>
            </ul>
            <a href="{{ route('subscriptions.create', ['service_name' => 'Standard', 'price' => 500, 'duration' => 2]) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg">Purchase Now</a>
        </div>

        <!-- Pro Plan -->
        <div class="border rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-xl font-bold text-center mb-4">Pro</h3>
            <p class="text-4xl font-bold text-center">₱1,200</p>
            <p class="text-center text-sm text-gray-600 mb-6">+ 5 Therapist Sessions</p>
            <ul class="mb-6 space-y-3">
                <li>✔️ Everything in Standard</li>
                <li>✔️ Personalized Wellness Plan</li>
                <li>✔️ Priority Support</li>
                <li>✔️ Access to Workshops</li>
            </ul>
            <a href="{{ route('subscriptions.create', ['service_name' => 'Pro', 'price' => 1200, 'duration' => 5]) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg">Purchase Now</a>
        </div>

        <!-- Enterprise Plan -->
        <div class="border rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-xl font-bold text-center mb-4">Enterprise</h3>
            <p class="text-4xl font-bold text-center">₱5,000</p>
            <p class="text-center text-sm text-gray-600 mb-6">+ 10 Therapist Sessions</p>
            <ul class="mb-6 space-y-3">
                <li>✔️ Everything in Pro</li>
                <li>✔️ Dedicated Therapist</li>
                <li>✔️ Custom Wellness Workshops</li>
                <li>✔️ Mental Health Analytics</li>
            </ul>
            <a href="{{ route('subscriptions.create', ['service_name' => 'Enterprise', 'price' => 5000, 'duration' => 10]) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg">Purchase Now</a>
        </div>
    </div>
</div>
</x-app-layout>
