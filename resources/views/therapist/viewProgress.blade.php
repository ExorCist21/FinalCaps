<title>View Appointment Progress</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Appointment Progress</h2>
                <p class="text-gray-500 text-sm">Details of all your appointments and their progress.</p>
            </div>

            <div class="p-4">
                @if($appointments->isEmpty())
                    <p class="text-red-500">You have no appointments with progress details yet.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($appointments as $appointment)
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-xl font-semibold text-gray-800">Appointment Details</h3>
                            <p class="text-gray-600 text-sm">Patient: {{ $appointment->patient->name }}</p>
                            <p class="text-gray-600 text-sm">Date: {{ $appointment->datetime }}</p>
                            <p class="text-gray-600 text-sm">Session Type: {{ $appointment->meeting_type }}</p>

                            <!-- Buttons Section -->
                            <div class="mt-4 flex justify-between">
                                <!-- View Details Button -->
                                <a href="{{ route('therapist.show.progress', ['appointmentID' => $appointment->appointmentID]) }}" 
                                class="bg-blue-500 text-white px-2 py-2 rounded-md hover:bg-blue-600">
                                View Progress
                                </a>

                                <!-- Update Progress Button -->
                                <button 
                                class="bg-green-500 text-white px-2 py-2 rounded-md hover:bg-green-600"
                                onclick="openModal({{ json_encode($appointment->progress) }}, {{ $appointment->appointmentID }})">
                                    Add Progress
                                </button>
                            </div>
                        </div>

                        <!-- Modal for Update Progress (inside the loop for unique IDs) -->
                        <div id="progress-modal-{{ $appointment->appointmentID }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                                <h3 class="text-xl font-semibold">Update Progress</h3>
                                <form id="progress-form-{{ $appointment->appointmentID }}" action="{{ route('therapist.appointment.updateProgress', ['appointmentID' => $appointment->appointmentID]) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Hidden field for Appointment ID -->
                                    <input type="hidden" id="appointment-id-{{ $appointment->appointmentID }}" name="appointment_id" value="{{ $appointment->appointment_id }}">

                                    <!-- Mental Condition -->
                                    <div class="mb-4">
                                        <label for="mental_condition-{{ $appointment->appointmentID }}" class="block text-sm font-medium text-gray-700">Mental Condition</label>
                                        <select id="mental_condition-{{ $appointment->appointmentID }}" name="mental_condition" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
                                            <option value="">Select...</option>
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
                                            <option value="">Select...</option>
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
                                            <option value="">Select...</option>
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
                                            <option value="">Select...</option>
                                            <option value="Ongoing">Ongoing</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Discharged">Discharged</option>
                                            <option value="In Remission">In Remission</option>
                                            <option value="Follow-up Scheduled">Follow-up Scheduled</option>
                                            <option value="In Crisis">In Crisis</option>
                                        </select>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mt-6 flex justify-between">
                                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Save Progress</button>
                                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600" onclick="closeModal({{ $appointment->appointmentID }})">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endif
            </div>

            <div class="p-4">
                <a href="{{ route('therapist.appointment') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Back to Appointments</a>
            </div>
        </div>
    </div>

    <!-- Pure JavaScript for Modal -->
    <script>
        function openModal(progressData, appointmentID) {
            // Populate the modal with existing progress data
            document.getElementById('appointment-id-' + appointmentID).value = appointmentID;

            // Show the modal
            document.getElementById('progress-modal-' + appointmentID).classList.remove('hidden');
        }

        function closeModal(appointmentID) {
            // Hide the modal based on the unique appointmentID
            document.getElementById('progress-modal-' + appointmentID).classList.add('hidden');
        }
    </script>
</x-app-layout>
