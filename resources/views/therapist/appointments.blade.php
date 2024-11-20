<title>Patient Appointments</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Patient Appointments') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="mb-5 flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-800">
                {{ __('Manage Appointments') }}
            </h3>

            <!-- Sort Dropdown -->
            <div class="mb-6">
                <select id="sortAppointments" 
                        class="w-48 rounded-md bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-800 border border-gray-300 focus:ring-2 focus:ring-indigo-600">
                    <option value="all" selected>All</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="disapproved">Disapproved</option>
                </select>
            </div>
        </div>

        @if ($appointments->isEmpty())
            <p class="text-center text-gray-600">No appointments found.</p>
        @else
            <div id="noAppointmentsMessage" class="hidden text-center text-gray-600 mb-4">
                No appointments found for the selected filter.
            </div>
            <div id="appointmentsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($appointments as $appointment)
                    <div class="appointment-card bg-white rounded-md p-6 border"
                         data-status="{{ $appointment->status }}">
                        <!-- Patient Image -->
                        <div class="flex items-center mb-4">
                            <img src="https://i.pravatar.cc/150?img={{ $appointment->patient->email ?? '1' }}" alt="Patient Image" class="w-12 h-12 ring-2 ring-indigo-600 rounded-full object-cover mr-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $appointment->patient->name ?? 'N/A' }}</h3>
                                <p class="text-sm text-gray-600 lower-case">{{ $appointment->patient->email ?? 'Unavailable' }}</p>
                            </div>
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
                                <form action="{{ route('therapist.approve', $appointment->appointmentID) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to approve this appointment?');">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-white bg-green-600 hover:bg-green-700 py-2 px-4 rounded-lg shadow-md focus:outline-none">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('therapist.disapprove', $appointment->appointmentID) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to disapprove this appointment?');">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-white bg-red-600 hover:bg-red-700 py-2 px-4 rounded-lg shadow-md focus:outline-none">
                                        Disapprove
                                    </button>
                                </form>
                            @elseif ($appointment->status == 'approved')
                                <span class="text-sm text-green-600">
                                    This appointment has been approved.
                                </span>
                            @elseif ($appointment->status == 'disapproved')
                                <span class="text-sm text-red-400">
                                    This appointment has been disapproved.
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