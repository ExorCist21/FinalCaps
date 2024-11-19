<title>Appointment Session</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Upcoming Appointments</h2>
                <p class="text-gray-500 text-sm">Here are your upcoming appointments. Click to edit the details.</p>
            </div>

            <!-- Appointment List -->
            <div class="p-4">
                @forelse($upcomingAppointments as $appointment)
                    <div class="flex justify-between items-center border-b border-gray-200 py-3">
                        <div>
                            <p class="font-semibold">{{ $appointment->patient->name }}</p>
                            <p class="text-gray-500 text-sm">{{ $appointment->datetime }}</p>
                        </div>
                        <div>
                            <a href="{{ route('therapist.viewSession', $appointment->appointmentID) }}" class="text-blue-600 hover:underline">Edit Meeting Details</a>
                        </div>
                        <div>
                            <form action="{{ route('therapist.markAsDone', $appointment->appointmentID) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                                    Submit (Mark as Done)
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No upcoming appointments.</p>
                @endforelse
            </div>

            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Done Appointments</h2>
                <p class="text-gray-500 text-sm">Here are your done appointments. Click to update the progress.</p>
            </div>

            <!-- Appointment List -->
            <div class="p-4">
                @forelse($doneAppointments as $appointment)
                    <div class="flex justify-between items-center border-b border-gray-200 py-3">
                        <div>
                            <p class="font-semibold">{{ $appointment->patient->name }}</p>
                            <p class="text-gray-500 text-sm">{{ $appointment->datetime }}</p>
                        </div>
                        <div> 
                            @if ($appointment->progress)  <!-- Check if progress already exists -->
                                <!-- If progress exists, show "Update Progress" -->
                                <a href="{{ route('therapist.updateProgress', $appointment->appointmentID) }}" class="text-blue-600 hover:underline">Update Progress</a>
                            @else
                                <!-- If no progress, show "Add Info" -->
                                <a href="{{ route('therapist.addInfo', $appointment->appointmentID) }}" class="text-blue-600 hover:underline">Add Info</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No done appointments.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
