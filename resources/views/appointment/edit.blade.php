<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Reschedule Appointment</h2>

        <form action="{{ route('appointments.update', $appointment->appointmentID) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="datetime" class="block text-sm font-medium text-gray-700 mb-1">New Date & Time</label>
                <input 
                    type="datetime-local" 
                    name="datetime" 
                    id="datetime"
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                    value="{{ old('datetime', \Carbon\Carbon::parse($appointment->datetime)->format('Y-m-d\TH:i')) }}" 
                    required
                >
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('therapist.appointment') }}" 
                   class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                    Cancel
                </a>

                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Update Appointment
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
