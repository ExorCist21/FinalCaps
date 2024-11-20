<title>Leave Feedback</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <h2 class="text-lg font-semibold">Leave Feedback for Your Appointment</h2>

            <form action="{{ route('appointments.feedback.store', ['appointmentId' => $appointment->appointmentID]) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="feedback" class="block text-sm font-medium text-gray-700">Your Feedback</label>
                    <textarea name="feedback" id="feedback" rows="4" class="mt-1 block w-full"></textarea>
                </div>

                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1-5)</label>
                    <input type="number" name="rating" id="rating" min="1" max="5" class="mt-1 block w-full">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Submit Feedback</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
