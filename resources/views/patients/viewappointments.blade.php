<title>My Appointments</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight text-center">
            {{ __('My Appointments') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row gap-6">
        <!-- Left Side: Appointment Management -->
        <div class="w-full md:w-2/3 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-2xl font-semibold text-gray-800 mb-4">Your Appointments</h3>

            @if ($appointments->isEmpty())
                <p class="text-center text-gray-600 text-lg">No appointments found.</p>
            @else
                <div id="appointmentsContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                    @foreach ($appointments as $appointment)
                        <div onclick="window.location.href='{{ route('meetingUser') }}?appointmentID={{ $appointment->appointmentID }}'" class="appointment-card bg-white rounded-xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center mb-4">
                                <img src="{{ asset('storage/' . $appointment->therapist->therapistInformation->image_picture) }}" alt="Therapist Image" class="w-14 h-14 ring-4 ring-indigo-600 rounded-full object-cover mr-6">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 capitalize">{{ $appointment->therapist->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $appointment->therapist->email }}</p>
                                </div>
                            </div>
                            <p class="text-sm font-medium text-gray-500">
                                {{ \Carbon\Carbon::parse($appointment->datetime)->format('F j, Y g:i A') }}
                            </p>
                            <p class="text-gray-600 mt-2">{{ $appointment->description }}</p>

                            <!-- Status -->
                            <p class="text-sm font-medium mt-2">
                                <strong>Status:</strong>
                                <span class="{{ $appointment->status == 'pending' ? 'text-pink-600' : ($appointment->status == 'approved' ? 'text-green-600' : 'text-red-600') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </p>
                            <div class="flex justify-between mt-4 mb-2 items-center">
                                @if ($appointment->status == 'pending')
                                    <span class="text-sm text-pink-600">Waiting for approval...</span>
                                @elseif ($appointment->status == 'approved')
                                    <span class="text-sm text-green-600">This appointment has been <span class="font-semibold text-green-700">approved</span>. Your therapist will reach out to you soon, or you may contact them directly for further details.</span>
                                @elseif ($appointment->status == 'disapproved')
                                    <span class="text-sm text-red-600">This appointment has been <span class="font-semibold text-red-700">disapproved</span>. Please check your messages for details or consider booking a new appointment.</span>
                                @endif
                            </div>
                            @if ($appointment->status == 'pending')
                                <form action="{{ route('patients.cancelApp', $appointment->appointmentID) }}" method="POST" class="inline ml-auto" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="text-xs font-medium text-white bg-red-500 hover:bg-red-600 py-2 px-4 rounded-lg shadow-md focus:outline-none transition-all duration-300 transform hover:scale-105">
                                        Cancel Appointment
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Side: Compact Calendar -->
        <div class="w-full md:w-1/3 bg-white p-5 rounded-lg shadow-md h-80">
            <div class="flex justify-between items-center mb-3">
                <button onclick="changeMonth(-1)" class="px-2 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">&larr;</button>
                <h3 id="currentMonth" class="text-lg font-semibold text-gray-800"></h3>
                <button onclick="changeMonth(1)" class="px-2 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm">&rarr;</button>
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
        const appointments = @json($appointments->groupBy(function($appointment) {
            return \Carbon\Carbon::parse($appointment->datetime)->format('Y-m-d');
        }));

        let currentDate = new Date();

        function renderCalendar() {
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            document.getElementById("currentMonth").innerText = `${monthNames[month]} ${year}`;

            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const prevMonthDays = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1;

            const calendarGrid = document.getElementById("calendarGrid");
            calendarGrid.innerHTML = "";

            for (let i = 0; i < prevMonthDays; i++) {
                const emptyCell = document.createElement("li");
                emptyCell.className = "text-gray-400";
                emptyCell.innerText = "-";
                calendarGrid.appendChild(emptyCell);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const hasAppointment = appointments[dateString] !== undefined;

                const dayCell = document.createElement("li");
                dayCell.className = `p-2 rounded-md cursor-pointer transition-all duration-300 ${hasAppointment ? 'bg-indigo-600 text-white font-bold hover:bg-indigo-700' : 'hover:bg-gray-200'}`;
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

            modalDate.innerHTML = `<h2 class="text-lg font-semibold text-gray-800">Your Appointment for this date.</h2>`;
            modalContent.innerHTML = '';

            if (appointments[date]) {
                appointments[date].forEach(appointment => {
                    modalContent.innerHTML += `
                        <div class="p-3 bg-gray-100 rounded-md mb-2">
                            <strong class="text-indigo-600">${appointment.therapist.name || 'Unknown Therapist'}</strong>
                            <p class="text-sm text-gray-700">${appointment.description}</p>
                            <p class="text-xs text-gray-500">Time: ${new Date(appointment.datetime).toLocaleTimeString()}</p>
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
