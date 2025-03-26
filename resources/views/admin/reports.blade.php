<title>Reports</title>
<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Admin Reports</h1>
            <p class="text-lg text-gray-600">Overview of your platform's key metrics and performance.</p>
        </div>

        <!-- Key Metrics Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-400 p-6 rounded-lg shadow-xl text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Total Appointments</h2>
                    <p class="text-3xl font-bold">{{ $totalAppointments }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-white opacity-75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div class="bg-gradient-to-r from-green-600 to-green-400 p-6 rounded-lg shadow-xl text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Completed Appointments</h2>
                    <p class="text-3xl font-bold">{{ $completedAppointments }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-white opacity-75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="bg-gradient-to-r from-red-600 to-red-400 p-6 rounded-lg shadow-xl text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Pending Appointments</h2>
                    <p class="text-3xl font-bold">{{ $pendingAppointments }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-white opacity-75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11l-7 7-7-7" />
                </svg>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-teal-400 p-6 rounded-lg shadow-xl text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Total Revenue</h2>
                    <p class="text-3xl font-bold">₱{{ number_format($totalRevenue, 2) }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-white opacity-75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10l3 3-3 3M10 13l-3-3 3-3" />
                </svg>
            </div>
            <div class="bg-gradient-to-r from-red-500 to-pink-400 p-6 rounded-lg shadow-xl text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Pending Payments</h2>
                    <p class="text-3xl font-bold">{{ $pendingPayments }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-white opacity-75" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v8m4-4H8" />
                </svg>
            </div>
        </div>

        <!-- Feedback Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Therapist Feedback -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-400 p-6 rounded-lg shadow-xl text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Therapist Feedbacks</h2>
                    <p class="text-3xl font-bold">{{ $feedbacks }}</p>
                </div>
                <a href="{{ route('admin.therapistFeedbacks') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    View Feedbacks
                </a>
            </div>

            <!-- System Feedback -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-400 p-6 rounded-lg shadow-xl text-white flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">System Feedbacks</h2>
                    <p class="text-3xl font-bold">{{ $systemfeedbacks }}</p>
                </div>
                <a href="{{ route('admin.systemFeedbacks') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    View Feedbacks
                </a>
            </div>
        </div>

        <!-- Top Therapists Section -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Top Therapists</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($topTherapists as $therapist)
                <div class="bg-white p-6 rounded-lg shadow-md transition duration-300 transform hover:scale-105 hover:shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-800">Therapist ID: {{ $therapist->therapistID }}</h3>
                    <h3 class="text-lg font-semibold text-gray-700">Therapist Name: {{ $therapist->therapist->name }}</h3>
                    <p class="text-sm text-gray-600 mt-2">Total Appointments:</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ $therapist->total }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
