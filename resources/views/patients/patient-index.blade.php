<title>Appointment Session</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Upcoming Appointments</h2>
                <p class="text-gray-500 text-sm">Here are your upcoming appointments. Click to view the details.</p>
            </div>

            <!-- Appointment List (Card Layout) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                @forelse($appointments as $appointment)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-3">
                                <div>
                                    <p class="font-semibold text-lg">{{ $appointment->patient->name }}</p>
                                    <p class="text-gray-500 text-sm">{{ $appointment->datetime }}</p>
                                </div>
                            </div>

                            <div class="text-gray-700">
                                <p class="mb-2">Status: 
                                    <span class="text-green-500 font-semibold">Upcoming</span>
                                </p>
                                <p class="mb-4">You have an appointment scheduled with {{ $appointment->therapist->name }}.</p>
                            </div>

                            <!-- Button to open modal -->
                            <div class="flex justify-end">
                                <button 
                                    class="text-blue-600 hover:underline"
                                    onclick="openModal('{{ $appointment->datetime }}', '{{ $appointment->session_meeting }}', '{{ $appointment->meeting_type }}')">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full">You have no upcoming appointments.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="appointmentModal" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Appointment Details</h3>
            <p id="modalDatetime" class="text-gray-700 mb-2"><strong>Datetime:</strong> </p>
            <p id="modalSessionMeeting" class="text-gray-700 mb-2"><strong>Session Meeting:</strong> </p>
            <p id="modalMeetingType" class="text-gray-700 mb-4"><strong>Meeting:</strong> </p>

            <div class="flex justify-end">
                <button 
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                    onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Function to open the modal and display appointment details
        function openModal(datetime, session_meeting, meeting_type) {
            document.getElementById('modalDatetime').innerHTML = `<strong>Datetime:</strong> ${datetime}`;
            document.getElementById('modalSessionMeeting').innerHTML = `<strong>Session Meeting:</strong> ${session_meeting}`;
            document.getElementById('modalMeetingType').innerHTML = `<strong>Meeting Type:</strong> ${meeting_type}`;
            document.getElementById('appointmentModal').classList.remove('hidden');
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
