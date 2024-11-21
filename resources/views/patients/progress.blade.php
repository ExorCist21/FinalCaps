<title>Your Progress</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Progress Timeline</h1>
            <p class="text-sm text-gray-500">Tracking your progess for Appointment #{{ $appointment->appointmentID }}</p>
        </div>

        @if ($appointment->progress->isNotEmpty())
            <!-- Progress Timeline -->
            <div class="relative border-l-4 border-indigo-500 pl-1.5">
                @foreach ($appointment->progress as $progress)
                    <div class="mb-10 relative flex items-start">
                        <!-- Timeline Dot -->
                        <div class="absolute -left-[1.25rem] top-1/2 transform -translate-y-1/2 w-6 h-6 bg-indigo-500 rounded-full border-2 border-white"></div>

                        <!-- Progress Details -->
                        <div class="p-4 w-full">
                            <p class="text-sm text-gray-500 mb-2">
                                {{ $progress->created_at->format('F j, Y, g:i A') }}
                            </p>
                            <p class="text-lg font-semibold text-gray-700 mb-2">Mental Condition: {{ $progress->mental_condition }}</p>
                            <p class="text-sm text-gray-600"><strong>Status:</strong> {{ ucfirst($progress->status) }}</p>
                            <p class="text-sm text-gray-600"><strong>Remarks:</strong> {{ $progress->remarks }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Progress Message -->
            <div class="text-center py-10">
                <p class="text-gray-500 text-lg">No progress details available for this appointment.</p>
            </div>
        @endif
    </div>
</x-app-layout>
