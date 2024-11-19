<!-- resources/views/patients/appointments.blade.php -->
<title>My Appointments</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('My Appointments') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5 relative"> <!-- Add 'relative' to the container -->
            <!-- Position the button to the upper-right corner -->
            <div class="absolute top-3 right-2 mt-3 mr-3">
                <a href="{{ route('patients.bookappointments') }}" class="py-2 pt-2 px-8 border-2 rounded-md bg-green-400 hover:bg-green-500 hover:text-white">Book Now!</a>
            </div>

            <h3 class="text-lg font-semibold mb-4">Your Appointments</h3>

            @if ($appointments->isEmpty())
                <p>No appointments found.</p>
            @else
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Appointment Date</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Therapist Name</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $appointment->appointmentID }}</td>
                                <td class="px-4 py-2">{{ $appointment->datetime }}</td>
                                <td class="px-4 py-2">{{ $appointment->description }}</td>
                                <td class="px-4 py-2">{{ $appointment->therapist->name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($appointment->status) }}</td>
                                @if ($appointment->status == 'pending')
                                    <td class="px-4 py-2">
                                        <form action="{{ route('patients.cancelApp', $appointment->appointmentID) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Cancel</button>
                                        </form>
                                    </td>
                                @elseif ($appointment->status == 'approved')
                                    <td class="px-4 py-2">You're all set! Appointment approved.</td>
                                @elseif ($appointment->status == 'disapproved')
                                    <td class="px-4 py-2">This appointment has been disapproved.</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
