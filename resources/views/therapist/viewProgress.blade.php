<title>Patient Progress</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Patient Progress') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="mb-5 flex items-center justify-between">
            <div>
            <h3 class="text-xl font-semibold text-gray-800">
                {{ __('Patients Progress') }}
            </h3>
            <p class="text-gray-500 text-sm">Select the patient to view detailed progress</p>
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
                                <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $appointment->patient->first_name ?? 'N/A' }} {{ $appointment->patient->last_name ?? 'N/A' }}</h3>
                                <p class="text-sm text-gray-600 lower-case">{{ $appointment->patient->email ?? 'Unavailable' }}</p>
                            </div>
                        </div>
                        <hr class="my-4"/>
                        <div class="flex justify-between mb-4">
                            <p class="text-sm font-medium text-gray-500">
                                Session Type: {{ $appointment->meeting_type }}
                            </p>
                        </div>
                        <div class="flex justify-between mb-4">
                            <p class="text-sm font-medium text-gray-500">
                                Date: {{ \Carbon\Carbon::parse($appointment->datetime)->format('F j, Y g:i A') }}
                            </p>
                        </div>
                        
                        <p class="text-gray-600 mb-4">
                            {{ $appointment->description }}
                        </p>

                        <p class="text-gray-600 mb-4">
                            @if ($appointment->progress && $appointment->progress->isNotEmpty())
                                @php
                                    $status = $appointment->progress->first()->status;
                                    $statusColor = '';
                                    if ($status === 'Ongoing') {
                                        $statusColor = 'text-red-500'; // Red for Ongoing
                                    } elseif ($status === 'Completed') {
                                        $statusColor = 'text-green-500'; // Green for Completed
                                    }
                                @endphp
                                <strong class="{{ $statusColor }}">Status:</strong> {{ $status }}<br>
                            @else
                                <p class="text-gray-600">No progress data available.</p>
                            @endif
                        </p>

                        <hr class="my-2"/>

                        <div class="flex justify-between mt-4 items-center">
                            <a href="{{ route('therapist.show.progress', ['appointmentID' => $appointment->appointmentID]) }}" 
                            class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 py-2 px-4 rounded-lg shadow-md focus:outline-none">
                                Detailed
                            </a>
                            @if($appointment->progress && !$appointment->progress->contains('status', 'Completed'))
                                <!-- Progress not completed yet -->
                                <button 
                                    type="submit" 
                                    onclick="openModal({{ json_encode($appointment->progress) }}, {{ $appointment->appointmentID }})" 
                                    class="text-sm font-medium text-white bg-green-600 hover:bg-green-700 py-2 px-4 rounded-lg shadow-md focus:outline-none">
                                    Add Progress
                                </button>

                            @else
                                <button
                                    type="button" 
                                    class="text-sm font-medium text-white bg-green-600 hover:bg-green-700 py-2 px-4 rounded-lg shadow-md focus:outline-none">
                                    Appointment Completed
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Send Payment Modal -->
                    <div id="sendPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                            <h2 class="text-lg font-semibold mb-4 text-center">Send Payment Proof to Admin</h2>

                            <!-- QR Image -->
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('images/gcashqr.jpg') }}" alt="Admin GCash QR Code" class="w-52 h-auto rounded border border-gray-300 shadow-md">
                            </div>

                            <form id="sendPaymentForm" enctype="multipart/form-data" action="{{ route('therapist.sendPayment', ['appointmentID' => $appointment->appointmentID]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="appointment_id" id="modalAppointmentId">
                                <input type="hidden" id="appointment-id-{{ $appointment->appointmentID }}" name="appointment_id" value="{{ $appointment->appointment_id }}">

                                <!-- Amount Input -->
                                <label for="amount" class="block mb-2 font-medium text-gray-700">Amount Sent</label>
                                <input type="number" step="0.01" name="amount" required class="w-full mb-4 border rounded px-3 py-2 focus:ring focus:ring-indigo-200 focus:outline-none">

                                <!-- File Input -->
                                <label for="proof" class="block mb-2 font-medium text-gray-700">Attach Payment Proof (Image/PDF)</label>
                                <input type="file" name="proof" required class="w-full mb-4 border rounded px-3 py-2 focus:ring focus:ring-indigo-200 focus:outline-none">

                                <!-- Buttons -->
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="closeSendPaymentModal()" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- GCash Info Modal -->
                    <div id="gcash-modal-{{ $appointment->appointmentID }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                            <h3 class="text-xl font-semibold">Add Your GCash Number</h3>
                            <form action="{{ route('therapist.addGcashNumber') }}" method="POST">
                                @csrf
                                <!-- Hidden Field for Appointment ID -->
                                <input type="hidden" name="appointment_id" value="{{ $appointment->appointmentID }}">
                                
                                <!-- GCash Number -->
                                <div class="mb-4">
                                    <label for="gcash_number" class="block text-sm font-medium text-gray-700">GCash Number</label>
                                    <input type="text" id="gcash_number" name="gcash_number" 
                                        class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" 
                                        placeholder="Enter GCash Number" required>
                                </div>

                                <!-- Submit and Cancel Buttons -->
                                <div class="flex justify-between items-center">
                                    <button type="button" onclick="closeGcashModal({{ $appointment->appointmentID }})" class="bg-gray-200 text-gray-900 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</button>
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Add GCash Info</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal for Update Progress (inside the loop for unique IDs) -->
                    <div id="progress-modal-{{ $appointment->appointmentID }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                            <h3 class="text-xl font-semibold">Add Progress</h3>
                            <form id="progress-form-{{ $appointment->appointmentID }}" action="{{ route('therapist.appointment.updateProgress', ['appointmentID' => $appointment->appointmentID]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Hidden field for Appointment ID -->
                                <input type="hidden" id="appointment-id-{{ $appointment->appointmentID }}" name="appointment_id" value="{{ $appointment->appointment_id }}">

                                <!-- Mental Condition -->
                                <div class="mb-4">
                                    <label for="mental_condition-{{ $appointment->appointmentID }}" class="block text-sm font-medium text-gray-700">Mental Condition</label>
                                    <select id="mental_condition-{{ $appointment->appointmentID }}" name="mental_condition" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
                                        <option value="Anxiety">Anxiety</option>
                                        <option value="Depression">Depression</option>
                                        <option value="Bipolar Disorder">Bipolar Disorder</option>
                                        <option value="PTSD">Post-Traumatic Stress Disorder (PTSD)</option>
                                        <option value="Schizophrenia">Schizophrenia</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <!-- Mood -->
                                <div class="mb-4">
                                    <label for="mood-{{ $appointment->appointmentID }}" class="block text-sm font-medium text-gray-700">Mood</label>
                                    <select id="mood-{{ $appointment->appointmentID }}" name="mood" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
                                        <option value="Happy">Happy</option>
                                        <option value="Sad">Sad</option>
                                        <option value="Irritable">Irritable</option>
                                        <option value="Anxious">Anxious</option>
                                        <option value="Calm">Calm</option>
                                        <option value="Angry">Angry</option>
                                        <option value="Euphoric">Euphoric</option>
                                    </select>
                                </div>

                                <!-- Symptoms -->
                                <div class="mb-4">
                                    <label for="symptoms-{{ $appointment->appointmentID }}" class="block text-sm font-medium text-gray-700">Symptoms</label>
                                    <textarea id="symptoms-{{ $appointment->appointmentID }}" name="symptoms" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" rows="1" required></textarea>
                                </div>

                                <!-- Remarks -->
                                <div class="mb-4">
                                    <label for="remarks-{{ $appointment->appointmentID }}" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="remarks-{{ $appointment->appointmentID }}" name="remarks" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" rows="1"></textarea>
                                </div>

                                <!-- Risk -->
                                <div class="mb-4">
                                    <label for="risk-{{ $appointment->appointmentID }}" class="block text-sm font-medium text-gray-700">Risk</label>
                                    <select id="risk-{{ $appointment->appointmentID }}" name="risk" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
                                        <option value="Low">Low</option>
                                        <option value="Moderate">Moderate</option>
                                        <option value="High">High</option>
                                        <option value="Critical">Critical</option>
                                        <option value="None">None</option>
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label for="status-{{ $appointment->appointmentID }}" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="status-{{ $appointment->appointmentID }}" name="status" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
                                        <option value="Ongoing">Ongoing</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Follow-up Scheduled">Follow-up Scheduled</option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-between items-center">
                                    <button type="button" onclick="closeModal({{ $appointment->appointmentID }})" class="bg-gray-200 text-gray-900 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</button>
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Save Progress</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    
    <!-- Pure JavaScript for Modal -->
    <script>
        function openModal(progressData, appointmentID) {
            // Populate the modal with existing progress data
            document.getElementById('appointment-id-' + appointmentID).value = appointmentID;
            document.getElementById('mental_condition-' + appointmentID).value = progressData.mental_condition || '';
            document.getElementById('mood-' + appointmentID).value = progressData.mood || '';
            document.getElementById('symptoms-' + appointmentID).value = progressData.symptoms || '';
            document.getElementById('remarks-' + appointmentID).value = progressData.remarks || '';
            document.getElementById('risk-' + appointmentID).value = progressData.risk || '';
            document.getElementById('status-' + appointmentID).value = progressData.status || '';

            // Show the modal
            document.getElementById('progress-modal-' + appointmentID).classList.remove('hidden');
        }

        function closeModal(appointmentID) {
            // Hide the modal based on the unique appointmentID
            document.getElementById('progress-modal-' + appointmentID).classList.add('hidden');
        }

        function openTherapistPaymentModal(appointmentID) {
            const form = document.getElementById('sendPaymentForm');

            // Get the correct hidden input value by using the dynamic ID
            const appointmentIdInput = document.getElementById(`appointment-id-${appointmentID}`);
            const realAppointmentId = appointmentIdInput ? appointmentIdInput.value : appointmentID;

            // Update form action and hidden input inside the modal
            form.action = `/send-payment/${realAppointmentId}`;
            document.getElementById('modalAppointmentId').value = realAppointmentId;

            // Show the modal
            document.getElementById('sendPaymentModal').classList.remove('hidden');
        }

        function openSendPaymentModal(appointmentID) {
            document.getElementById('modalAppointmentId').value = appointmentID;
            document.getElementById('sendPaymentModal').classList.remove('hidden');
        }

        function closeSendPaymentModal() {
            document.getElementById('sendPaymentModal').classList.add('hidden');
        }

        function openGcashModal(appointmentID) {
            // Show the modal
            document.getElementById('gcash-modal-' + appointmentID).classList.remove('hidden');
        }

        function closeGcashModal(appointmentID) {
            // Hide the modal
            document.getElementById('gcash-modal-' + appointmentID).classList.add('hidden');
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