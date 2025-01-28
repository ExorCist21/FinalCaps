<title>Patient Appointments</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight text-center">
            {{ __('Patient Appointments') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- Section Title -->
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-2xl font-semibold text-gray-800">
                {{ __('Manage Appointments') }}
            </h3>

            <!-- Sort Dropdown -->
            <div class="mb-6">
                <select id="sortAppointments" 
                        class="w-48 rounded-md bg-gradient-to-r from-indigo-100 via-indigo-200 to-indigo-300 px-4 py-2 text-sm font-semibold text-gray-800 border border-indigo-400 focus:ring-2 focus:ring-indigo-600 transition-all duration-300 ease-in-out">
                    <option value="all" selected>All</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="disapproved">Disapproved</option>
                </select>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="mb-8">
            <div id="calendar" class="mb-8 rounded-lg shadow-lg border border-gray-200 p-4 bg-white max-w-4xl mx-auto"></div>
        </div>

        <!-- Appointment Modal -->
        <div id="appointmentModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-800"></h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                        &times;
                    </button>
                </div>
                <div class="mb-4">
                    <p id="modalDescription" class="text-gray-600"></p>
                </div>
                <div class="flex justify-between items-center">
                    <p id="modalDatetime" class="text-sm text-gray-500"></p>
                    <span id="modalStatus" class="text-sm font-medium"></span>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        @if ($appointments->isEmpty())
            <p class="text-center text-gray-600 text-lg">No appointments found.</p>
        @else
            <!-- No Appointments Filter Message -->
            <div id="noAppointmentsMessage" class="hidden text-center text-gray-600 mb-4">
                No appointments found for the selected filter.
            </div>

            <!-- Appointments List -->
            <div id="appointmentsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($appointments as $appointment)
                    <div class="appointment-card bg-white rounded-xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:rotate-1 ease-in-out"
                         data-status="{{ $appointment->status }}">
                        <!-- Patient Image -->
                        <div class="flex items-center mb-6">
                            <img src="https://i.pravatar.cc/150?img={{ $appointment->patient->email ?? '1' }}" alt="Patient Image" class="w-14 h-14 ring-4 ring-indigo-600 rounded-full object-cover mr-6">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 capitalize">{{ $appointment->patient->name ?? 'N/A' }}</h3>
                                <p class="text-sm text-gray-600">{{ $appointment->patient->email ?? 'Unavailable' }}</p>
                            </div>
                        </div>

                        <!-- Appointment Details -->
                        <div class="flex justify-between mb-4">
                            <p class="text-sm font-medium text-gray-500">
                                {{ $appointment->datetime }}
                            </p>
                            <span class="text-sm font-medium text-gray-500">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>

                        <!-- Appointment Description -->
                        <p class="text-gray-600 mb-6">
                            {{ $appointment->description }}
                        </p>

                        <hr class="my-4 border-gray-200"/>

                        <!-- Action Buttons -->
                        <div class="flex justify-between mt-4 items-center">
                            @if ($appointment->status == 'pending')
                                <form action="{{ route('therapist.approve', $appointment->appointmentID) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to approve this appointment?');">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-white bg-green-600 hover:bg-green-700 py-2 px-4 rounded-lg shadow-md focus:outline-none transition-all duration-300 transform hover:scale-105">
                                        Approve
                                    </button>
                                </form>
                                <form action="{{ route('therapist.disapprove', $appointment->appointmentID) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to disapprove this appointment?');">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-white bg-red-600 hover:bg-red-700 py-2 px-4 rounded-lg shadow-md focus:outline-none transition-all duration-300 transform hover:scale-105">
                                        Disapprove
                                    </button>
                                </form>
                            @elseif ($appointment->status == 'approved')
                                <span class="text-sm text-green-600 font-medium">
                                    This appointment has been approved.
                                </span>
                            @elseif ($appointment->status == 'disapproved')
                                <span class="text-sm text-red-400 font-medium">
                                    This appointment has been disapproved.
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Include FullCalendar CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize FullCalendar
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay',
                },
                events: [
                    @foreach ($appointments as $appointment)
                        @if($appointment->status === 'approved')
                            {
                                title: "{{ $appointment->patient->name ?? 'Unknown Patient' }}",
                                start: "{{ $appointment->datetime }}",
                                description: "{{ $appointment->description }}",
                                status: "{{ ucfirst($appointment->status) }}",
                            },
                        @endif
                    @endforeach
                ],
                eventClick: function(info) {
                    // Populate modal with event details
                    document.getElementById('modalTitle').innerText = info.event.title;
                    document.getElementById('modalDescription').innerText = info.event.extendedProps.description || 'No description available.';
                    document.getElementById('modalDatetime').innerText = `Date & Time: ${new Date(info.event.start).toLocaleString()}`;
                    
                    // Add status styling dynamically
                    const statusElement = document.getElementById('modalStatus');
                    statusElement.innerText = `Status: ${info.event.extendedProps.status}`;
                    if (info.event.extendedProps.status === 'Pending') {
                        statusElement.className = 'text-sm font-medium text-pink-600';
                    } else if (info.event.extendedProps.status === 'Approved') {
                        statusElement.className = 'text-sm font-medium text-green-600';
                    } else if (info.event.extendedProps.status === 'Disapproved') {
                        statusElement.className = 'text-sm font-medium text-red-500';
                    }

                    // Show modal
                    document.getElementById('appointmentModal').classList.remove('hidden');
                },
                height: 'auto',
                eventColor: '#6366f1',
                eventTextColor: 'white',
                eventBorderColor: '#6366f1',
                dayCellClassNames: 'bg-gray-50',
            });

            calendar.render();
            // Modal functionality
            const modal = document.getElementById('appointmentModal');
            const closeModal = document.getElementById('closeModal');
            closeModal.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
