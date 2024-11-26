<title>Reports</title>
<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Admin Reports</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-600">Total Appointments</h2>
                <p class="text-3xl font-bold text-blue-600">{{ $totalAppointments }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-600">Completed Appointments</h2>
                <p class="text-3xl font-bold text-green-600">{{ $completedAppointments }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-600">Pending Appointments</h2>
                <p class="text-3xl font-bold text-red-600">{{ $pendingAppointments }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-600">Total Revenue</h2>
                <p class="text-3xl font-bold text-green-600">${{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-600">Pending Payments</h2>
                <p class="text-3xl font-bold text-red-600">{{ $pendingPayments }}</p>
            </div>
        </div>

        <h2 class="text-xl font-semibold text-gray-800 mb-4">Top Therapists</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($topTherapists as $therapist)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700">Therapist ID: {{ $therapist->therapistID }}</h3>
                    <h3 class="text-lg font-semibold text-gray-700">Therapist Name: {{ $therapist->therapist->name }}</h3>
                    <p class="text-sm text-gray-600 mt-2">Total Appointments:</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $therapist->total }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
