<title>Appointment History</title>
<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="max-w-7xl mx-auto">
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8 bg-gradient-to-r from-pastel-mint-100 to-pastel-peach-100 rounded-lg shadow-2xl relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-pastel-gray-100 opacity-30 rounded-lg -z-10"></div>

                <!-- Upcoming Appointments -->
                <div class="bg-white p-6 rounded-lg shadow-lg border border-pastel-gray-100 hover:shadow-2xl transform transition duration-300 hover:scale-105">
                    <h2 class="text-2xl font-semibold text-pastel-indigo-500 mb-3">Upcoming Appointments</h2>
                    <p class="text-gray-500 text-sm mb-4">Here are your upcoming appointments. Click to view the details.</p>
                    <div>
                        @forelse($appointments as $appointment)
                            <div class="appointment-card flex justify-between items-center border-b border-gray-200 py-4 relative bg-gradient-to-r from-pastel-blue-100 to-pastel-indigo-100 rounded-lg shadow-sm hover:shadow-xl transition duration-300">
                                <div class="w-full">
                                    <p class="font-semibold text-pastel-blue-100 capitalize">{{ $appointment->description }}</p>
                                    <p class="text-gray-600 text-sm"> with <span class="capitalize font-semibold text-pastel-indigo-500">{{ $appointment->therapist->name }}</span></p>
                                    <p class="text-gray-500 text-sm"> on {{ \Carbon\Carbon::parse($appointment->datetime)->format('F j, Y g:i A') }}</p>
                                </div>
                                <div>
                                <button
                                    class="text-pastel-indigo-500 hover:text-pastel-indigo-400 border-b-2 border-transparent hover:border-pastel-indigo-500 py-1 flex items-center transition duration-300 transform hover:scale-105"
                                    onclick="openModal('{{ $appointment->datetime }}', '{{ $appointment->session_meeting }}', '{{ $appointment->meeting_type }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7-7 7M5 5l7 7-7 7"></path>
                                    </svg>
                                    View Details
                                </button>

                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No upcoming appointments.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Completed Appointments -->
                <div class="bg-white p-6 rounded-lg shadow-lg border border-pastel-gray-100 hover:shadow-2xl transform transition duration-300 hover:scale-105">
                    <h2 class="text-2xl font-semibold text-pastel-indigo-500 mb-3">Completed Appointments</h2>
                    <p class="text-gray-500 text-sm mb-4">Here are your completed appointments. Click to give feedback.</p>
                    <div>
                        @forelse ($doneAppointments as $appointment)
                            <div class="appointment-card flex justify-between items-center border-b border-gray-200 py-4 relative bg-gradient-to-r from-pastel-lavender-100 to-pastel-pink-100 rounded-lg shadow-sm hover:shadow-xl transition duration-300">
                                <div class="w-full">
                                    <p class="font-semibold text-pastel-blue-100 capitalize">{{ $appointment->description }}</p>
                                    <p class="text-gray-600 text-sm"> with <span class="capitalize font-semibold text-pastel-indigo-500">{{ $appointment->therapist->name }}</span></p>
                                    <p class="text-gray-500 text-sm"> on {{ \Carbon\Carbon::parse($appointment->datetime)->format('F j, Y g:i A') }}</p>
                                </div>
                                <div>
                                    @php
                                        $feedbackExists = $appointment->feedback()
                                            ->where('patient_id', auth()->id())
                                            ->exists();
                                    @endphp

                                    @if ($feedbackExists)
                                        <span class="text-green-600 font-semibold">Feedback Provided</span>
                                    @else
                                        <a href="{{ route('appointments.feedback.create', ['appointmentId' => $appointment->appointmentID]) }}" 
                                           class="text-pastel-green-500 hover:text-pastel-green-400 mx-2 py-1 flex items-center transition duration-300 transform hover:scale-105">
                                           <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                               <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m9-9l-9 9-9-9"></path>
                                           </svg>
                                           Provide Feedback
                                        </a>
                                    @endif  
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No completed appointments available.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- View Details Modal -->
            <div id="appointmentModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-500 opacity-0">
                <div class="bg-white rounded-lg shadow-2xl p-8 max-w-lg w-full transform transition-all duration-500 scale-90 opacity-0">
                    <h3 class="text-2xl font-semibold text-pastel-indigo-500 mb-6">Appointment Details</h3>
                    <p id="modalDatetime" class="text-gray-700 mb-4"><strong>Datetime:</strong> </p>
                    <p id="modalSessionMeeting" class="text-gray-700 mb-4"><strong>Session Meeting:</strong> </p>
                    <p id="modalMeetingType" class="text-gray-700 mb-6"><strong>Meeting Type:</strong> </p>

                    <div class="flex justify-end">
                        <button 
                            class="bg-pastel-gray-100 text-gray-900 px-6 py-3 rounded-md hover:bg-pastel-gray-200 transition duration-300"
                            onclick="closeModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(datetime, session_meeting, meeting_type) {
            document.getElementById('modalDatetime').innerHTML = `<strong>Datetime:</strong> ${datetime}`;
            document.getElementById('modalSessionMeeting').innerHTML = `<strong>Session Meeting:</strong> ${session_meeting}`;
            document.getElementById('modalMeetingType').innerHTML = `<strong>Meeting Type:</strong> ${meeting_type}`;

            // Show modal with smooth transition
            let modal = document.getElementById('appointmentModal');
            modal.classList.remove('hidden');
            modal.classList.add('opacity-100');
            modal.querySelector('div').classList.remove('scale-90', 'opacity-0');
            modal.querySelector('div').classList.add('scale-100', 'opacity-100');
        }

        function closeModal() {
            let modal = document.getElementById('appointmentModal');
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-90', 'opacity-0');
            modal.querySelector('div').classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 500); // Timeout to allow transition to complete
        }

        document.addEventListener("DOMContentLoaded", function () {
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
