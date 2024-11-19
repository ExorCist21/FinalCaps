<!-- resources/views/patient/progress.blade.php -->
<title>Your Progress</title>
<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Progress Timeline for Appointment #{{ $appointment->appointmentID }}</h1>

        @if ($appointment->progress->isNotEmpty())
            <div class="relative border-l-2 border-gray-300 pl-6">
                @foreach ($appointment->progress as $progress)
                    <div class="mb-8">
                        <div class="absolute left-0 top-0 w-2 h-2 bg-blue-600 rounded-full mt-1.5 -ml-1.5"></div>

                        <div class="flex items-center">
                            <p class="font-semibold text-gray-700">{{ $progress->created_at->format('F j, Y, g:i A') }}</p>
                        </div>

                        <div class="ml-6 mt-4">
                            <p><strong>Mental Condition:</strong> {{ $progress->mental_condition }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($progress->status) }}</p>
                            <p><strong>Remarks:</strong> {{ $progress->remarks }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No progress details available for this appointment.</p>
        @endif
    </div>
</x-app-layout>
