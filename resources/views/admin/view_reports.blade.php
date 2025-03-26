<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Page Header -->
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Feedback Reports</h1>
            <p class="text-lg text-gray-600">Review feedback from patients and therapists.</p>
        </div>

        <!-- Therapist Feedback Section -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Therapist Feedback</h2>
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-3 text-left">Patient</th>
                        <th class="border p-3 text-left">Therapist</th>
                        <th class="border p-3 text-left">Feedback</th>
                        <th class="border p-3 text-left">Rating</th>
                        <th class="border p-3 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($therapistFeedbacks as $feedback)
                        <tr class="hover:bg-gray-50">
                            <td class="border p-3">{{ $feedback->patient->name }}</td>
                            <td class="border p-3">{{ $feedback->therapist->name }}</td>
                            <td class="border p-3">{{ $feedback->feedback }}</td>
                            <td class="border p-3 text-center">{{ $feedback->rating }}/5</td>
                            <td class="border p-3">{{ $feedback->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- System Feedback Section -->
        <h2 class="text-xl font-semibold text-gray-800 mb-4">System Feedback</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-3 text-left">User</th>
                        <th class="border p-3 text-left">Feedback</th>
                        <th class="border p-3 text-left">Rating</th>
                        <th class="border p-3 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($systemFeedbacks as $feedback)
                        <tr class="hover:bg-gray-50">   
                            <td class="border p-3">{{ $feedback->user->name }}</td>
                            <td class="border p-3">{{ $feedback->system_feedback }}</td>
                            <td class="border p-3">{{ $feedback->system_rating }}</td>
                            <td class="border p-3">{{ $feedback->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
