<title>System Feedbacks</title>
<x-app-layout>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">System Feedback</h1>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-4 border-b bg-gray-100">
                <h2 class="text-lg font-semibold text-gray-700">User Feedback List</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left border">User</th>
                            <th class="py-3 px-6 text-left border">Feedback</th>
                            <th class="py-3 px-6 text-center border">Rating</th>
                            <th class="py-3 px-6 text-left border">Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach($systemFeedbacks as $feedback)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 border">{{ $feedback->user->name }}</td>
                                <td class="py-3 px-6 border">{{ $feedback->system_feedback }}</td>
                                <td class="py-3 px-6 text-center border font-semibold text-blue-600">
                                    ⭐ {{ $feedback->system_rating }}/5
                                </td>
                                <td class="py-3 px-6 border">{{ $feedback->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
