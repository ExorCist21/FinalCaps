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
                            <img src="{{ asset('storage/' . $appointment->therapist->therapistInformation->image_picture) }}" alt="Therapist Image"
                                class="w-14 h-14 ring-4 ring-indigo-600 rounded-full object-cover mr-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 capitalize">{{ $appointment->therapist->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $appointment->therapist->email ?? 'Unavailable' }}</p>
                                <p class="text-sm text-gray-600">{{ $appointment->therapist->therapistInformation->contact_number ?? 'Unavailable' }}</p>
                            </div>
                        </div>

                        <hr class="my-4" />

                        <!-- Appointment Details -->
                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-500">
                                <strong>Session Type:</strong> {{ ucfirst($appointment->meeting_type) }}
                            </p>
                            <p class="text-sm font-medium text-gray-500">
                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->datetime)->format('F j, Y g:i A') }}
                            </p>
                            <p class="text-sm font-medium text-gray-500">
                                <strong>Consultation Type:</strong> {{ $appointment->description }}
                            </p>
                        </div>

                        @if ($appointment->progress->isNotEmpty())
                            <strong>Status:</strong> 
                            <span class="font-semibold 
                                @if($appointment->progress->last()->status == 'Completed') text-green-600 
                                @elseif($appointment->progress->last()->status == 'Ongoing') text-yellow-600 
                                @else text-red-600 
                                @endif">
                                {{ ucfirst($appointment->progress->last()->status) }}
                            </span>
                        @else
                            <strong>Status:</strong> <span class="font-semibold text-gray-600">No progress available</span>
                        @endif

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
