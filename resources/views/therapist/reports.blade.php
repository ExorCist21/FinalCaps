<title>My Reports</title>
<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Therapist Reports</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-600">Total Appointments</h2>
                <p class="text-3xl font-bold text-blue-600">{{ $appointments }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-600">Completed Appointments</h2>
                <p class="text-3xl font-bold text-green-600">{{ $completedAppointments }}</p>
            </div>
        </div>

        <h2 class="text-xl font-semibold text-gray-800 mb-4">Patient Progress</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($patientProgress as $progress)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700">Appointment ID: {{ $progress->appointment_id }} </h3>
                    <h3 class="text-md font-semibold text-gray-700">Mental Condition:</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ $progress->mental_condition }}</p>
                    
                    <h3 class="text-md font-semibold text-gray-700 mt-4">Mood:</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ $progress->mood }}</p>
                    
                    <h3 class="text-md font-semibold text-gray-700 mt-4">Remarks:</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ $progress->remarks }}</p>
                    
                    <h3 class="text-md font-semibold text-gray-700 mt-4">Status:</h3>
                    <p class="text-gray-600 text-sm mt-1">{{ $progress->status }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
