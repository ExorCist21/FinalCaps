<title>Appointment Progress</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight text-center">
            {{ __('Appointment Progress') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-semibold text-gray-800">Your Appointments' Progress</h3>
                <p class="text-gray-500 text-sm">View and manage your appointment progress.</p>
            </div>
        </div>

        <!-- No Appointments Found -->
        @if ($appointments->isEmpty())
            <p class="text-center text-gray-600 text-lg">No appointments found.</p>
        @else
            <div id="appointmentsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($appointments as $appointment)
                    <div class="appointment-card bg-white rounded-xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:rotate-1 ease-in-out cursor-pointer"
                        onclick="window.location='{{ route('patient.show.progress', $appointment->appointmentID) }}'">
                        <!-- Therapist Information -->
                        <div class="flex items-center mb-6">
                            <img src="https://i.pravatar.cc/150?img={{ $appointment->therapist->email ?? '1' }}" alt="Therapist Image"
                                class="w-14 h-14 ring-4 ring-indigo-600 rounded-full object-cover mr-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 capitalize">{{ $appointment->therapist->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $appointment->therapist->email ?? 'Unavailable' }}</p>
                            </div>
                        </div>

                        <hr class="my-4" />

                        <!-- Appointment Details -->
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">
                                <strong>Session Type:</strong> {{ $appointment->meeting_type }}
                            </p>
                            <p class="text-sm font-medium text-gray-500">
                                <strong>Date:</strong> {{ $appointment->datetime }}
                            </p>
                        </div>

                        <p class="text-gray-600 mb-6">
                            <strong>Status:</strong> <span class="font-semibold text-green-600">{{ ucfirst($appointment->status) }}</span>
                        </p>

                        <hr class="my-2" />

                        <!-- Action Buttons -->
                        <div class="flex justify-between mt-6 items-center">
                            <a href="{{ route('patient.show.progress', ['appointmentID' => $appointment->appointmentID]) }}"
                                class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 py-2 px-4 rounded-lg shadow-md focus:outline-none transition-all duration-300 ease-in-out">
                                View Progress
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
