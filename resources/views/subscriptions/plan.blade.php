<title>Plan</title>
<x-app-layout>
<section id="pricing" class="relative isolate bg-white max-w-7xl mx-auto">
        <div class="absolute inset-x-0 -top-3 -z-10 transform-gpu overflow-hidden px-36 blur-3xl" aria-hidden="true">
          <div class="mx-auto aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
        </div>
        <div class="mx-auto max-w-4xl sm:text-center">
          <p class="mt-2 text-balance text-2xl sm:text-5xl font-semibold tracking-tight text-gray-900 sm:text-6xl">Choose the right sessions for you</p>
        </div>
        <p class="mx-auto mt-2 sm:mt-6 text-pretty sm:text-center text-lg font-medium text-gray-600 sm:text-xl/8">
            Select from a variety of tailored sessions designed to help you achieve your goals. Start your journey towards better health and wellness today.
        </p>
        <div class="mx-auto mt-6 sm:mt-16 grid grid-cols-1 items-center gap-y-6 sm:mt-20 sm:gap-y-0 lg:max-w-6xl lg:grid-cols-3">
            <div class="rounded-3xl rounded-t-3xl bg-white/60 text-center p-8 ring-1 ring-gray-900/10 sm:mx-8 sm:rounded-b-none sm:p-10 lg:mx-0 lg:rounded-bl-3xl lg:rounded-tr-none">
                <h3 id="tier-hobby" class="text-4xl text-center font-bold text-indigo-600 mb-5">Standard</h3>
                <p class="text-5xl font-semibold text-center text-gray-900 mb-5">
                ₱1200
                </p>
                <p class="text-base/7 text-gray-600 text-center">+ 1 Therapist Session</p>
                <a href="{{ route('subscriptions.create', ['service_name' => 'Standard', 'price' => 1200, 'duration' => 1]) }}" aria-describedby="tier-hobby" class="mt-8 block rounded-md px-3.5 py-2.5 text-center text-sm font-semibold text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:mt-10">Purchase</a>
            </div>

            <div class="relative rounded-3xl bg-gray-900 p-8 shadow-2xl ring-1 ring-gray-900/10 sm:p-10">
                <h3 id="tier-enterprise" class="text-7xl text-center font-bold text-yellow-600 mb-5 mt-10">Pro</h3>
                <p class="text-5xl font-semibold text-center text-gray-200 mb-5">
                ₱5,500
                </p>
                <p class="text-base/7 text-gray-300 text-center">+ 5 Therapist Session</p>
                <a href="{{ route('subscriptions.create', ['service_name' => 'Pro', 'price' => 5500, 'duration' => 5]) }}" aria-describedby="tier-enterprise" class="mt-8 mb-10 block rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 sm:mt-10">Purchase</a>
            </div>

            <div class="rounded-3xl rounded-t-3xl bg-white/60 p-8 ring-1 ring-gray-900/10 sm:mx-8 sm:rounded-b-none sm:p-10 lg:mx-0 lg:rounded-br-3xl lg:rounded-tl-none">
                <h3 id="tier-hobby" class="text-4xl text-center font-bold text-indigo-600 mb-5">Enterprise</h3>
                <p class="text-5xl font-semibold text-center text-gray-900 mb-5">
                ₱2,200
                </p>
                <p class="text-base/7 text-gray-600 text-center">+ 2 Therapist Session</p>
                <a href="{{ route('subscriptions.create', ['service_name' => 'Enterprise', 'price' => 2200, 'duration' => 2]) }}" aria-describedby="tier-hobby" class="mt-8 block rounded-md px-3.5 py-2.5 text-center text-sm font-semibold text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:mt-10">Purchase</a>
            </div>
        </div>
    </section>
</x-app-layout>