<title>Appointment Progress</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Appointment Progress') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-semibold text-gray-800">Your Appointments' Progress</h3>
                <p class="text-gray-500 text-sm">View and manage your appointment progress.</p>
            </div>
        </div>

        @if ($appointments->isEmpty())
            <p class="text-center text-gray-600">No appointments found.</p>
        @else
            <div id="appointmentsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($appointments as $appointment)
                    <div class="appointment-card bg-white rounded-lg p-6 border hover:shadow-lg transition-shadow duration-200 cursor-pointer"
                        onclick="window.location='{{ route('patient.show.progress', $appointment->appointmentID) }}'">
                        <!-- Therapist Information -->
                        <div class="flex items-center mb-4">
                            <img src="https://i.pravatar.cc/150?img={{ $appointment->therapist->email ?? '1' }}" alt="Therapist Image"
                                class="w-12 h-12 ring-2 ring-indigo-600 rounded-full object-cover mr-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $appointment->therapist->name }}</h3>
                                <p class="text-sm text-gray-600 lower-case">{{ $appointment->therapist->email ?? 'Unavailable' }}</p>
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

                        <p class="text-gray-600 mb-4">
                            <strong>Status:</strong> <span class="font-semibold text-green-600">{{ ucfirst($appointment->status) }}</span>
                        </p>

                        <hr class="my-2" />

                        <!-- Action Buttons -->
                        <div class="flex justify-between mt-4 items-center">
                            <a href="{{ route('patient.show.progress', ['appointmentID' => $appointment->appointmentID]) }}"
                                class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 py-2 px-4 rounded-lg shadow-md focus:outline-none">
                                View Progress
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
