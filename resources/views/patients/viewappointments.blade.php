<title>My Appointments</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('My Appointments') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-800">
                {{ __('Your Appointments') }}
            </h3>
        </div>

        <div class="mb-5 flex items-center justify-between">
            <div class="mb-6">
                <!-- Sort Dropdown -->
                <select id="sortAppointments" 
                        class="w-48 rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-800 border border-gray-300 focus:ring-2 focus:ring-indigo-600">
                    <option value="all" selected>All</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="disapproved">Disapproved</option>
                </select>
            </div>
            <a href="{{ route('patients.bookappointments') }}" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Book Now!
            </a>
        </div>

        @if ($appointments->isEmpty())
            <p class="text-center text-gray-600">No appointments found.</p>
        @else
            <div id="noAppointmentsMessage" class="hidden text-center text-gray-600 mb-4">
                No appointments found for the selected filter.
            </div>
            <div id="appointmentsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($appointments as $appointment)
                    <div class="appointment-card bg-white rounded-md p-6 border" data-status="{{ $appointment->status }}">
                        <!-- Therapist Image -->
                        <div class="flex items-center mb-4">
                            <img src="https://i.pravatar.cc/150?img={{ $appointment->therapist->email }}" alt="Therapist Image" class="w-12 h-12 ring-2 ring-indigo-600 rounded-full object-cover mr-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $appointment->therapist->name }}</h3>
                                <p class="text-sm text-gray-600 lower-case">{{ $appointment->therapist->email }}</p>
                            </div>
                            @if ($appointment->status == 'pending')
                                <form action="{{ route('patients.cancelApp', $appointment->appointmentID) }}" method="POST" class="inline ml-auto" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="text-xs font-medium text-white bg-red-500 hover:bg-red-600 py-2 px-4 rounded-lg shadow-md focus:outline-none">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                        <hr class="my-4"/>
                        <div class="flex justify-between mb-4">
                            <p class="text-sm font-medium text-gray-500">
                                {{ $appointment->datetime }}
                            </p>
                            <span class="text-sm font-medium text-gray-500">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4">
                            {{ $appointment->description }}
                        </p>

                        <hr class="my-2"/>
                        
                        <div class="flex justify-between mt-4 items-center">
                            @if ($appointment->status == 'pending')
                                <span class="text-sm">
                                    Waiting for approval...
                                </span>
                            @elseif ($appointment->status == 'approved')
                                <span class="text-sm">
                                    This appointment has been <span class="text-green-600">approved.</span>
                                </span>
                            @elseif ($appointment->status == 'disapproved')
                                <span class="text-sm">
                                    This appointment has been <span class="text-red-400">disapproved.</span>
                                </span>
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
            const appointmentsContainer = document.getElementById('appointmentsContainer');
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
