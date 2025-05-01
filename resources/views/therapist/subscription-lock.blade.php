<title>Account Locked</title>
<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="bg-white p-8 rounded shadow-md max-w-lg text-center">
            <h1 class="text-2xl font-bold text-red-600 mb-4">Subscription Required</h1>
            <p class="text-gray-700 mb-6">
                Your have no service plan subscribed or your subscription has ended. To continue using MentalWell, please subscribe to a plan.
            </p>
            <a href="{{ route('subscriptions.index') }}"
               class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700">
                Subscribe Now
            </a>
        </div>
    </div>
</x-app-layout>
