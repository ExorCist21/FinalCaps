<title>Patient Session</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-7xl mx-auto">
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Upcoming Appointments -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Upcoming Appointments</h2>
                    <p class="text-gray-500 text-sm mb-4">Here are your upcoming appointments. Click to view the details.</p>
                    <div>
                        @forelse($appointments as $appointment)
                            <div class="flex justify-between items-center border-b border-gray-200 py-3">
                                <div>
                                    <p class="font-semibold capitalize">{{ $appointment->description }}</p>
                                    <p class="text-gray-500 text-sm"> with <span class="capitalize font-semibold text-gray-700">{{ $appointment->therapist->name }}</span></p>
                                    <p class="text-gray-500 text-sm"> on {{ $appointment->datetime }}</p>
                                </div>
                                <div>
                                    <button 
                                        class="text-blue-600 hover:border-b-2 hover:border-b-blue-600 mx-2 py-1"
                                        onclick="openModal('{{ $appointment->datetime }}', '{{ $appointment->session_meeting }}', '{{ $appointment->meeting_type }}')">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No upcoming appointments.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Completed Appointments -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Completed Appointments</h2>
                    <p class="text-gray-500 text-sm mb-4">Here are your completed appointments. Click to give feedback.</p>
                    <div>
                        @forelse ($doneAppointments as $appointment)
                            <div class="flex justify-between items-center border-b border-gray-200 py-3">
                                <div>
                                    <p class="font-semibold capitalize">{{ $appointment->description }}</p>
                                    <p class="text-gray-500 text-sm"> with <span class="capitalize font-semibold text-gray-700">{{ $appointment->therapist->name }}</span></p>
                                    <p class="text-gray-500 text-sm"> on {{ $appointment->datetime }}</p>
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
                                           class="text-blue-600 hover:border-b-2 hover:border-b-blue-600 mx-2 py-1">
                                           Provide Feedback
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No completed appointments available.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- View Details Modal -->
            <div id="appointmentModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full">
                    <h3 class="text-xl font-semibold mb-4">Appointment Details</h3>
                    <p id="modalDatetime" class="text-gray-700 mb-2"><strong>Datetime:</strong> </p>
                    <p id="modalSessionMeeting" class="text-gray-700 mb-2"><strong>Session Meeting:</strong> </p>
                    <p id="modalMeetingType" class="text-gray-700 mb-4"><strong>Meeting Type:</strong> </p>

                    <div class="flex justify-end">
                        <button 
                            class="bg-gray-200 text-gray-900 px-4 py-2 rounded-md hover:bg-gray-300"
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
            document.getElementById('appointmentModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
