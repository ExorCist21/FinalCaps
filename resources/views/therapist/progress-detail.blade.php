<x-app-layout>
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Appointment Progress</h1>

    <!-- Appointment Details -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700">Appointment Details</h2>
        <p><strong>Therapist:</strong> {{ $appointment->therapist->name }}</p>
        <p><strong>Patient:</strong> {{ $appointment->patient->name }}</p>
        <p><strong>Date & Time:</strong> {{ $appointment->datetime }}</p>
        <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
        <p><strong>Meeting Type:</strong> {{ ucfirst($appointment->meeting_type) }}</p>
    </div>

    <!-- Progress Details -->
    @if ($appointment->progress)
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-700">Progress Details</h2>
        <p><strong>Mental Condition:</strong> {{ $appointment->progress->mental_condition }}</p>
        <p><strong>Mood:</strong> {{ $appointment->progress->mood }}</p>
        <p><strong>Symptoms:</strong> {{ $appointment->progress->symptoms }}</p>
        <p><strong>Risk Assessment:</strong> {{ $appointment->progress->risk }}</p>
        <p><strong>Remarks:</strong> {{ $appointment->progress->remarks }}</p>
        <p><strong>Progress Status:</strong> {{ ucfirst($appointment->progress->status) }}</p>
    </div>
    @else
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
        <p>No progress details are available for this appointment yet.</p>
    </div>
    @endif
</div>
</x-app-layout>
