<title>Appointment Progress</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Your Appointments</h1>

        @if ($appointments->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($appointments as $appointment)
                    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-200 cursor-pointer"
                        onclick="window.location='{{ route('patient.show.progress', $appointment->appointmentID) }}'">
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">{{ $appointment->therapist->name }}</h2>
                        <p class="text-gray-600">Date: {{ $appointment->datetime }}</p>
                        <p class="text-gray-500">Session Type: {{ $appointment->meeting_type }}</p>
                        <p class="text-gray-500">Status: <span class="font-semibold text-green-600">{{ ucfirst($appointment->status) }}</span></p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">You have no upcoming appointments.</p>
        @endif
    </div>
</x-app-layout>
