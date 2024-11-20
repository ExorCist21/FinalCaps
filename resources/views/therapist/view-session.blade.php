<!-- resources/views/therapist/view-session.blade.php -->
<title>Scheduling</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Edit Consultation Schedule</h2>
                <p class="text-gray-500 text-sm">Modify the meeting type and details for this appointment.</p>
            </div>

            <form action="{{ route('therapist.storeSession', $appointment->appointmentID) }}" method="POST" class="p-4">
                @csrf
                @method('POST')

                <div class="mb-4">
                    <label for="meeting_type" class="block text-sm font-medium text-gray-700">Meeting Type</label>
                    <select 
                        name="meeting_type" 
                        id="meeting_type" 
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    >
                        <option value="online" {{ old('meeting_type', $appointment->meeting_type) == 'online' ? 'selected' : '' }}>Online (Google Meet)</option>
                        <option value="in-person" {{ old('meeting_type', $appointment->meeting_type) == 'in-person' ? 'selected' : '' }}>In-Person</option>
                    </select>
                    @error('meeting_type')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="session_meeting" class="block text-sm font-medium text-gray-700">Meeting Details</label>
                    <input 
                        type="text" 
                        name="session_meeting" 
                        id="session_meeting" 
                        value="{{ old('session_meeting', $appointment->session_meeting) }}"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Enter the address or Google Meet link"
                    >
                    @error('session_meeting')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200">
                    Save Schedule
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
