<title>Leave Feedback</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-7xl mx-auto">
            
            <!-- Therapist Image -->
            <div class="flex items-center p-6">
                <img src="https://i.pravatar.cc/150?img={{ $appointment->therapist->email }}" alt="Therapist Image" class="w-12 h-12 ring-2 ring-indigo-600 rounded-full object-cover mr-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $appointment->therapist->name }}</h3>
                    <p class="text-sm text-gray-600 lower-case">{{ $appointment->therapist->email }}</p>
                </div>
            </div>

            <form action="{{ route('appointments.feedback.store', ['appointmentId' => $appointment->appointmentID]) }}" method="POST" class="p-6">
                @csrf

                <h2 class="text-2xl font-bold text-gray-800">Leave Feedback</h2>
                <p class="text-sm text-gray-500 mb-6">We value your feedback to improve our services. Please share your experience below.</p>

                <!-- Feedback Textarea -->
                <div class="mb-6">
                    <label for="feedback" class="block text-sm font-medium text-gray-700">Your Feedback</label>
                    <textarea 
                        name="feedback" 
                        id="feedback" 
                        rows="5" 
                        placeholder="Write your feedback here..." 
                        class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm resize-none"
                        required></textarea>
                </div>

                <!-- Rating Input -->
                <div class="mb-6">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                    <p class="text-sm text-gray-500 mb-2">Rate your experience on a scale of 1 to 5.</p>
                    <select 
                        name="rating" 
                        id="rating" 
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                        required>
                        <option value="" disabled selected>Choose a rating</option>
                        <option value="1">1 - Very Poor</option>
                        <option value="2">2 - Poor</option>
                        <option value="3">3 - Average</option>
                        <option value="4">4 - Good</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-md shadow-md focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
