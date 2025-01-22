<title>Leave Feedback</title>
<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="max-w-7xl mx-auto bg-white p-8 rounded-xl shadow-xl hover:shadow-2xl transition-shadow duration-300">
            
            <!-- Therapist Image and Info -->
            <div class="flex items-center mb-8">
                <img src="https://i.pravatar.cc/150?img={{ $appointment->therapist->email }}" alt="Therapist Image" class="w-16 h-16 ring-4 ring-indigo-600 rounded-full object-cover mr-6 transform transition-transform duration-300 hover:scale-110">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800">{{ $appointment->therapist->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $appointment->therapist->email }}</p>
                </div>
            </div>

            <!-- Feedback Form -->
            <form action="{{ route('appointments.feedback.store', ['appointmentId' => $appointment->appointmentID]) }}" method="POST">
                @csrf

                <h2 class="text-3xl font-semibold text-gray-800 mb-4">Leave Your Feedback</h2>
                <p class="text-sm text-gray-500 mb-6">Your feedback helps us improve. Please share your experience with us.</p>

                <!-- Feedback Textarea -->
                <div class="mb-6">
                    <label for="feedback" class="block text-sm font-medium text-gray-700">Your Feedback</label>
                    <textarea 
                        name="feedback" 
                        id="feedback" 
                        rows="6" 
                        placeholder="Write your feedback here..." 
                        class="mt-2 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm resize-none"
                        required></textarea>
                </div>

                <!-- Rating Input -->
                <div class="mb-6">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                    <p class="text-sm text-gray-500 mb-2">Rate your experience on a scale of 1 to 5.</p>
                    <select 
                        name="rating" 
                        id="rating" 
                        class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
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
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-md shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
