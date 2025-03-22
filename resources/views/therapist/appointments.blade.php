<title>Patient Appointments</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight text-center">
            {{ __('Patient Appointments') }}
        </h2>
    </x-slot>

    <!-- Left Side: Appointment Management -->
    <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row gap-6">
        <!-- Left Side: Appointment Management -->
        <div class="w-full md:w-2/3">
            <!-- Sort Dropdown -->
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-2xl font-semibold text-gray-800">
                    {{ __('Manage Appointments') }}
                </h3>
                <select id="sortAppointments" 
                        class="w-48 rounded-md bg-gradient-to-r from-indigo-100 via-indigo-200 to-indigo-300 px-4 py-2 text-sm font-semibold text-gray-800 border border-indigo-400 focus:ring-2 focus:ring-indigo-600 transition-all duration-300 ease-in-out">
                    <option value="all" selected>All</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="disapproved">Disapproved</option>
                </select>
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
            <div id="appointmentsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
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
                                {{ \Carbon\Carbon::parse($appointment->datetime)->format('F j, Y g:i A') }}
                            </p>
                        </div>

                        <!-- Appointment Description -->
                        <p class="text-gray-600 mb-6">
                            {{ $appointment->description }}
                        </p>
                        
                        <!-- Display Risk Level -->
                        <p class="text-sm font-medium text-gray-500">
                            <strong>Risk Level:</strong> 
                            <span class="
                                {{ $appointment->risk_level == 'Low' ? 'text-green-500' : '' }}
                                {{ $appointment->risk_level == 'Moderate' ? 'text-yellow-500' : '' }}
                                {{ $appointment->risk_level == 'High' ? 'text-orange-500' : '' }}
                                {{ $appointment->risk_level == 'Critical' ? 'text-red-500' : '' }}">
                                {{ $appointment->risk_level }}
                            </span>
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
                                <span class="text-sm text-green-600">This appointment has been <span class="font-semibold text-green-700">approved</span>. Your patient will message you soon, or you may message them directly.</span>
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
            <!-- Right Side: Compact Calendar -->
            <div class="w-full md:w-1/3 bg-white p-4 rounded-lg shadow-md h-80">
                <div class="flex justify-between items-center mb-3">
                    <button onclick="changeMonth(-1)" class="px-2 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">
                        &larr;
                    </button>
                    <h3 id="currentMonth" class="text-lg font-semibold text-gray-800"></h3>
                    <button onclick="changeMonth(1)" class="px-2 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">
                        &rarr;
                    </button>
                </div>
                <ul class="grid grid-cols-7 gap-1 text-gray-600 text-xs font-medium mb-1">
                    <li class="text-center">Mon</li>
                    <li class="text-center">Tue</li>
                    <li class="text-center">Wed</li>
                    <li class="text-center">Thu</li>
                    <li class="text-center">Fri</li>
                    <li class="text-center">Sat</li>
                    <li class="text-center">Sun</li>
                </ul>
                <ul id="calendarGrid" class="grid grid-cols-7 gap-1 text-center text-gray-800 font-medium text-sm"></ul>
            </div>
        </div>

        <!-- Appointment Modal -->
        <div id="appointmentModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-5">
                <div class="flex justify-between items-center mb-3">
                    <h3 id="modalDate" class="text-lg font-semibold text-gray-800"></h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>
                <div id="modalContent" class="text-gray-700 text-sm"></div>
            </div>
        </div>
    </div>

    

    <script>
        document.getElementById("sortAppointments").addEventListener("change", function () {
        const selectedStatus = this.value;
        const appointments = document.querySelectorAll(".appointment-card");

        appointments.forEach((appointment) => {
            const status = appointment.getAttribute("data-status");

            if (selectedStatus === "all" || status === selectedStatus) {
                appointment.classList.remove("hidden");
            } else {
                appointment.classList.add("hidden");
            }
        });

        // Show message if no appointments are found
        const visibleAppointments = document.querySelectorAll(".appointment-card:not(.hidden)");
        document.getElementById("noAppointmentsMessage").classList.toggle("hidden", visibleAppointments.length > 0);
    });

        const appointments = @json($appointments->groupBy(function($appointment) {
            return \Carbon\Carbon::parse($appointment->datetime)->format('Y-m-d');
        }));

        let currentDate = new Date();

        function renderCalendar() {
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            document.getElementById("currentMonth").innerText = `${monthNames[month]} ${year}`;

            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const prevMonthDays = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1;

            const calendarGrid = document.getElementById("calendarGrid");
            calendarGrid.innerHTML = "";

            // Add empty days for alignment
            for (let i = 0; i < prevMonthDays; i++) {
                const emptyCell = document.createElement("li");
                emptyCell.className = "text-gray-400";
                emptyCell.innerText = "-";
                calendarGrid.appendChild(emptyCell);
            }

            // Fill in the actual days
            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const hasAppointment = appointments[dateString] !== undefined;

                const dayCell = document.createElement("li");
                dayCell.className = `p-2 rounded-md cursor-pointer transition-all duration-300
                    ${hasAppointment ? 'bg-indigo-600 text-white font-bold hover:bg-indigo-700' : 'hover:bg-gray-200'}`;
                dayCell.innerText = day;

                if (hasAppointment) {
                    dayCell.innerHTML += `<span class="block text-xs mt-1">📌</span>`;
                    dayCell.addEventListener("click", () => showAppointmentsForDay(dateString));
                }

                calendarGrid.appendChild(dayCell);
            }
        }

        function changeMonth(step) {
            currentDate.setMonth(currentDate.getMonth() + step);
            renderCalendar();
        }

        function showAppointmentsForDay(date) {
            const modal = document.getElementById('appointmentModal');
            const modalContent = document.getElementById('modalContent');
            const modalDate = document.getElementById('modalDate');

            modalDate.innerHTML = "<h1>Your Appointment for this date.</h1>";
            modalContent.innerHTML = '';

            if (appointments[date]) {
                appointments[date].forEach(appointment => {
                    modalContent.innerHTML += `
                        <div class="p-3 bg-gray-100 rounded-md mb-2">
                            <strong>${appointment.patient.name || 'Unknown Patient'}</strong>
                            <p class="text-sm">${appointment.description}</p>
                            <p class="text-xs text-gray-500">${new Date(appointment.datetime).toLocaleTimeString()}</p>
                        </div>
                    `;
                });
            } else {
                modalContent.innerHTML = '<p class="text-gray-500">No appointments for this day.</p>';
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }

        document.addEventListener("DOMContentLoaded", renderCalendar);
        

        document.addEventListener('DOMContentLoaded', function () {
            
            @if(session('success'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonColor: "#4CAF50",
                confirmButtonText: "OK"
            });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    icon: "error",
                    confirmButtonColor: "#E53935",
                    confirmButtonText: "OK"
                });
            @endif
        });
    </script>
</x-app-layout>
