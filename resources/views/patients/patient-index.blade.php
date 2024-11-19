<title>Appointment Session</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Upcoming Appointments</h2>
                <p class="text-gray-500 text-sm">Here are your upcoming appointments. Click to view the details.</p>
            </div>

            <!-- Appointment List (Card Layout) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                @forelse($appointments as $appointment)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <div>
                                    <p class="font-semibold text-lg">{{ $appointment->patient->name }}</p>
                                    <p class="text-gray-500 text-sm">{{ $appointment->datetime }}</p>
                                </div>
                            </div>

                            <div class="text-gray-700">
                                <p class="mb-2">Status: 
                                    <span class="text-green-500 font-semibold">Upcoming</span>
                                </p>
                                <p class="mb-4">You have an appointment scheduled with {{ $appointment->therapist->name }}.</p>
                            </div>

                            <!-- Button to view details and edit -->
                            <div class="flex justify-end">
                                <a href="{{ route('patient.viewSession', $appointment->appointmentID) }}" class="text-blue-600 hover:underline">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full">You have no upcoming appointments.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
