<title>Plan</title>
<x-app-layout>
<div class="max-w-7xl mx-auto py-12">
    <h2 class="text-3xl font-bold text-center mb-8">MentalWell Session Plans</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Basic Plan -->
        <div class="border rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-xl font-bold text-center mb-8">Standard</h3>
            <p class="text-4xl font-bold text-center mb-8">₱500</p>
            <p class="text-center text-xl text-gray-600 mb-8">+ 2 Therapist Session</p>
            <a href="{{ route('subscriptions.create', ['service_name' => 'Standard', 'price' => 500, 'duration' => 2]) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg">Purchase Now</a>
        </div>

        <!-- Pro Plan -->
        <div class="border rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-xl font-bold text-center mb-8">Pro</h3>
            <p class="text-4xl font-bold text-center mb-8">₱1,200</p>
            <p class="text-center text-xl text-gray-600 mb-8">+ 5 Therapist Sessions</p>
            <a href="{{ route('subscriptions.create', ['service_name' => 'Pro', 'price' => 1200, 'duration' => 5]) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg">Purchase Now</a>
        </div>

        <!-- Enterprise Plan -->
        <div class="border rounded-lg shadow-lg p-6 bg-white">
            <h3 class="text-xl font-bold text-center mb-8">Enterprise</h3>
            <p class="text-4xl font-bold text-center mb-8">₱5,000</p>
            <p class="text-center text-xl text-gray-600 mb-8">+ 10 Therapist Sessions</p>
            <a href="{{ route('subscriptions.create', ['service_name' => 'Enterprise', 'price' => 5000, 'duration' => 10]) }}" class="block text-center bg-blue-500 text-white px-4 py-2 rounded-lg">Purchase Now</a>
        </div>
    </div>
</div>
</x-app-layout>
