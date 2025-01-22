<title>My Appointments</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight text-center">
            {{ __('My Appointments') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Section Title -->
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-2xl font-semibold text-gray-800">
                {{ __('Your Appointments') }}
            </h3>
        </div>

        <!-- Sort Dropdown & Book Appointment Button -->
        <div class="mb-6 flex items-center justify-between">
            <div class="mb-6">
                <!-- Sort Dropdown -->
                <select id="sortAppointments" 
                        class="w-48 rounded-md bg-gradient-to-r from-indigo-100 via-indigo-200 to-indigo-300 px-4 py-2 text-sm font-semibold text-gray-800 border border-indigo-400 focus:ring-2 focus:ring-indigo-600 transition-all duration-300 ease-in-out">
                    <option value="all" selected>All</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="disapproved">Disapproved</option>
                </select>
            </div>
            <!-- Book Now Button -->
            <a href="{{ route('patients.bookappointments') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 transition-all duration-300 ease-in-out"> 
                Book Now!
            </a>
        </div>

        <!-- No Appointments Found -->
        @if ($appointments->isEmpty())
            <p class="text-center text-gray-600 text-lg">No appointments found.</p>
        @else
            <div id="noAppointmentsMessage" class="hidden text-center text-gray-600 mb-4">
                No appointments found for the selected filter.
            </div>

            <!-- Appointments List -->
            <div id="appointmentsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($appointments as $appointment)
                    <div class="appointment-card bg-white rounded-xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:rotate-1 ease-in-out" data-status="{{ $appointment->status }}">
                        <!-- Therapist Image and Info -->
                        <div class="flex items-center mb-6">
                            <img src="https://i.pravatar.cc/150?img={{ $appointment->therapist->email }}" alt="Therapist Image" class="w-14 h-14 ring-4 ring-indigo-600 rounded-full object-cover mr-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 capitalize">{{ $appointment->therapist->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $appointment->therapist->email }}</p>
                            </div>
                            @if ($appointment->status == 'pending')
                                <form action="{{ route('patients.cancelApp', $appointment->appointmentID) }}" method="POST" class="inline ml-auto" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="text-xs font-medium text-white bg-red-500 hover:bg-red-600 py-2 px-4 rounded-lg shadow-md focus:outline-none transition-all duration-300 transform hover:scale-105">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </div>

                        <hr class="my-4"/>

                        <!-- Appointment Details -->
                        <div class="flex justify-between mb-4">
                            <p class="text-sm font-medium text-gray-500">{{ $appointment->datetime }}</p>
                            <span class="text-sm font-medium text-gray-500">{{ ucfirst($appointment->status) }}</span>
                        </div>
                        
                        <p class="text-gray-600 mb-6">{{ $appointment->description }}</p>

                        <hr class="my-2"/>

                        <!-- Appointment Status Message -->
                        <div class="flex justify-between mt-4 items-center">
                            @if ($appointment->status == 'pending')
                                <span class="text-sm text-pink-600">Waiting for approval...</span>
                            @elseif ($appointment->status == 'approved')
                                <span class="text-sm text-green-600">This appointment has been <span class="font-semibold text-green-700">approved</span>.</span>
                            @elseif ($appointment->status == 'disapproved')
                                <span class="text-sm text-red-500">This appointment has been <span class="font-semibold text-red-400">disapproved</span>.</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sortSelect = document.getElementById('sortAppointments');
            const appointmentCards = document.querySelectorAll('.appointment-card');
            const noAppointmentsMessage = document.getElementById('noAppointmentsMessage');

            sortSelect.addEventListener('change', function () {
                const filter = this.value;
                let visibleCount = 0;

                appointmentCards.forEach(card => {
                    const status = card.getAttribute('data-status');

                    if (filter === 'all' || filter === status) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show or hide the "No appointments" message based on visibleCount
                if (visibleCount === 0) {
                    noAppointmentsMessage.classList.remove('hidden');
                } else {
                    noAppointmentsMessage.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>
