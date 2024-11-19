<title>Appointment Session</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-7xl mx-auto">
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Upcoming Appointments -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Upcoming Appointments</h2>
                    <p class="text-gray-500 text-sm mb-4">Here are your upcoming appointments. Click to edit the details.</p>
                    <div>
                        @forelse($upcomingAppointments as $appointment)
                            <div class="flex justify-between items-center border-b border-gray-200 py-3">
                                <div>
                                    <p class="font-semibold">{{ $appointment->patient->name }}</p>
                                    <p class="text-gray-500 text-sm">{{ $appointment->datetime }}</p>
                                </div>
                                <div class="ml-auto">
                                    <a href="{{ route('therapist.viewSession', $appointment->appointmentID) }}"
                                    class="text-blue-600 hover:border-b-2 hover:border-b-blue-600 mx-2 py-1">
                                        Edit
                                    </a>
                                    <a href="#" 
                                    onclick="event.preventDefault(); markAsDone('{{ route('therapist.markAsDone', $appointment->appointmentID) }}')" 
                                    class="text-green-600 hover:border-b-2 hover:border-b-green-600 mx-2 py-1">
                                        Complete
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No upcoming appointments.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Done Appointments -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Done Appointments</h2>
                    <p class="text-gray-500 text-sm mb-4">Here are your done appointments. Click to update the progress.</p>
                    <div>
                        @forelse($doneAppointments as $appointment)
                            <div class="flex justify-between items-center border-b border-gray-200 py-3">
                                <div>
                                    <p class="font-semibold">{{ $appointment->patient->name }}</p>
                                    <p class="text-gray-500 text-sm">{{ $appointment->datetime }}</p>
                                </div>
                                <div> 
                                    @if ($appointment->progress)
                                        <a href="{{ route('therapist.progress', ['appointmentID' => $appointment->appointmentID]) }}"
                                        class="text-blue-600 hover:border-b-2 hover:border-b-blue-600 mx-2 py-1">
                                            View Progress
                                        </a>
                                    @else
                                        <button onclick="openModal({{ $appointment->appointmentID }})" class="text-blue-600 hover:border-b-2 hover:border-b-blue-600 mx-2 py-1">Add Info</button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">No done appointments.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Add Info Modal -->
            <div id="addInfoModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full">
                    <h3 class="text-xl font-semibold mb-4">Add Appointment Info</h3>
                    <form id="addInfoForm" action="{{ route('therapist.storeProgress', $appointment->appointmentID) }}" method="POST">
                        @csrf
                        <!-- Mental Condition -->
                        <div class="mb-4">
                            <label for="mental_condition" class="block text-sm font-medium text-gray-700">Mental Condition</label>
                            <select id="mental_condition" name="mental_condition" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
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
                            <label for="mood" class="block text-sm font-medium text-gray-700">Mood</label>
                            <select id="mood" name="mood" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
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
                            <label for="symptoms" class="block text-sm font-medium text-gray-700">Symptoms</label>
                            <textarea id="symptoms" name="symptoms" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" rows="1" required></textarea>
                        </div>

                        <!-- Remarks -->
                        <div class="mb-4">
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea id="remarks" name="remarks" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" rows="1"></textarea>
                        </div>

                        <!-- Risk -->
                        <div class="mb-4">
                            <label for="risk" class="block text-sm font-medium text-gray-700">Risk</label>
                            <select id="risk" name="risk" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
                                <option value="Low">Low</option>
                                <option value="Moderate">Moderate</option>
                                <option value="High">High</option>
                                <option value="Critical">Critical</option>
                                <option value="None">None</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md" required>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                                <option value="Discharged">Discharged</option>
                                <option value="In Remission">In Remission</option>
                                <option value="Follow-up Scheduled">Follow-up Scheduled</option>
                                <option value="In Crisis">In Crisis</option>
                            </select>
                        </div>

                        <div class="flex justify-between items-center">
                            <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModal(appointmentId) {
            const modal = document.getElementById('addInfoModal');
            const form = document.getElementById('addInfoForm');
            form.action = `/therapist/session/${appointmentId}/progress`;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('addInfoModal');
            modal.classList.add('hidden');
        }

        function markAsDone(url) {
        if (confirm('Are you sure you want to mark this appointment as done?')) {
            fetch(url, {
                method: 'POST', // Use POST instead of PUT
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ _method: 'PUT' }) // Include the `_method` override
            })
            .then(response => {
                if (response.ok) {
                    alert('Appointment marked as done.');
                    window.location.reload(); // Reload to reflect changes
                } else {
                    alert('An error occurred while marking the appointment as done.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }
    </script>

</x-app-layout>
