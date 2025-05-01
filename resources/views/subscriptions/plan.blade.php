<title>Plan</title>
<x-app-layout>
    <section id="pricing" class="relative isolate bg-white px-6 py-12 lg:px-8">
        <div class="absolute inset-x-0 -top-3 -z-10 transform-gpu overflow-hidden px-36 blur-3xl" aria-hidden="true">
            <div class="mx-auto aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        <div class="mx-auto max-w-4xl text-center">
            <p class="text-3xl sm:text-5xl font-semibold tracking-tight text-gray-900">
                Therapist Subscription Plans
            </p>
        </div>
        <p class="mx-auto mt-4 sm:mt-6 text-center text-lg text-gray-600 sm:text-xl">
            Subscribe to MentalWell and enjoy unlimited access to all features, appointments, and support tools for your practice.
        </p>

        <div class="mx-auto mt-10 grid grid-cols-1 gap-8 lg:max-w-6xl lg:grid-cols-3">
            <!-- Half-Month Plan -->
            <div class="rounded-3xl bg-white/60 p-8 text-center ring-1 ring-gray-900/10 shadow-sm">
                <h3 class="text-4xl font-bold text-indigo-600 mb-5">Half Month</h3>
                <p class="text-5xl font-semibold text-gray-900 mb-5">₱750</p>
                <p class="text-base text-gray-600">Unlimited Appointments for 15 Days</p>
                <a href="{{ route('subscriptions.create', ['service_name' => 'half_month', 'price' => 750, 'duration' => 15]) }}"
                    class="mt-8 block rounded-md px-3.5 py-2.5 text-sm font-semibold text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300">
                    Subscribe Now
                </a>
            </div>

            <!-- 1-Month Plan (Most Popular) -->
            <div class="relative rounded-3xl bg-gray-900 p-8 text-center shadow-2xl ring-1 ring-gray-900/10">
                <h3 class="text-5xl font-bold text-yellow-500 mb-5">1 Month</h3>
                <p class="text-5xl font-semibold text-white mb-5">₱1,200</p>
                <p class="text-base text-gray-300">Unlimited Appointments for 30 Days</p>
                <a href="{{ route('subscriptions.create', ['service_name' => 'month', 'price' => 1200, 'duration' => 30]) }}"
                    class="mt-8 block rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400">
                    Subscribe Now
                </a>
            </div>

            <!-- Yearly Plan -->
            <div class="rounded-3xl bg-white/60 p-8 text-center ring-1 ring-gray-900/10 shadow-sm">
                <h3 class="text-4xl font-bold text-indigo-600 mb-5">Yearly</h3>
                <p class="text-5xl font-semibold text-gray-900 mb-5">₱12,000</p>
                <p class="text-base text-gray-600">Unlimited Appointments for 1 Year</p>
                <a href="{{ route('subscriptions.create', ['service_name' => 'yearly', 'price' => 12000, 'duration' => 365]) }}"
                    class="mt-8 block rounded-md px-3.5 py-2.5 text-sm font-semibold text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300">
                    Subscribe Now
                </a>
            </div>
        </div>
    </section>
</x-app-layout>