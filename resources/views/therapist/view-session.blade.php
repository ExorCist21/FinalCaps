<title>Scheduling</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <!-- Patient Information -->
        <div class="bg-gray-100 p-4 rounded-md mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Patient Information</h3>
            <div class="flex items-center mb-4">
                <img src="https://i.pravatar.cc/150?img={{ $appointment->patient->email ?? '1' }}" alt="Patient Image" class="w-12 h-12 ring-2 ring-indigo-600 rounded-full object-cover mr-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $appointment->patient->name ?? 'N/A' }}</h3>
                    <p class="text-sm text-gray-600 lower-case">{{ $appointment->patient->email ?? 'Unavailable' }}</p>
                </div>
                <p class="text-gray-700 ml-auto">{{ $appointment->datetime }}</p>
            </div>
        </div>

        <!-- Header Section -->
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">Update Consultation</h2>
            <p class="text-gray-500 text-sm">You can modify the meeting type and details for this appointment.</p>
        </div>

        <!-- Form Section -->
        <form action="{{ route('therapist.storeSession', $appointment->appointmentID) }}" method="POST" class="p-4">
            @csrf
            @method('POST')

            <div class="mb-6">
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

            <div class="mb-6">
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

            <button type="submit" class="w-full py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition duration-200">
                Update Consultation
            </button>
        </form>
    </div>
</x-app-layout>
