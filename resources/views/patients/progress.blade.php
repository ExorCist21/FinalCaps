<title>Your Progress</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with sticky effect -->
        <div class="mb-6 border-b pb-4 sticky top-0 bg-white z-10 shadow-md">
            <h1 class="text-3xl font-bold text-gray-800">Progress Timeline</h1>
            <p class="text-sm text-gray-500">Tracking your progress for Appointment #{{ $appointment->appointmentID }}</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="relative pt-2">
                <div class="flex mb-2">
                    <div class="flex-1 text-center text-sm font-semibold text-gray-600">Start</div>
                    <div class="flex-1 text-center text-sm font-semibold text-gray-600">In Progress</div>
                    <div class="flex-1 text-center text-sm font-semibold text-gray-600">Completed</div>
                </div>
                <div class="flex h-2 rounded-full bg-gray-200">
                    <!-- Dynamic Progress Bar based on progress, checking if total_steps is not zero -->
                    @if($appointment->total_steps > 0)
                        <div class="w-{{ 100 / $appointment->total_steps * $appointment->completed_steps }}% bg-indigo-500 rounded-full"></div>
                    @else
                        <div class="w-full bg-gray-300 rounded-full"></div> <!-- Show empty bar if no total steps -->
                    @endif
                </div>
            </div>
        </div>

        @if ($appointment->progress->isNotEmpty())
            <!-- Progress Timeline -->
            <div class="relative border-l-4 border-indigo-500 pl-4">
                @foreach ($appointment->progress as $progress)
                    <div class="mb-10 relative flex items-start group">
                        <!-- Timeline Dot with animation -->
                        <div class="absolute -left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 bg-indigo-500 rounded-full border-4 border-white shadow-lg transition-transform duration-300 scale-100 group-hover:scale-110"></div>

                        <!-- Progress Details -->
                        <div class="p-6 w-full bg-gradient-to-r from-indigo-50 via-blue-50 to-indigo-100 shadow-lg rounded-lg mb-4 hover:shadow-xl transition-shadow duration-300 group">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-gray-500">
                                    {{ $progress->created_at->format('F j, Y, g:i A') }}
                                </p>
                                <div class="flex items-center">
                                    <span class="inline-block py-1 px-3 text-sm font-semibold rounded-full 
                                        @if($progress->status == 'completed') bg-green-100 text-green-800 hover:bg-green-200 
                                        @elseif($progress->status == 'in-progress') bg-yellow-100 text-yellow-800 hover:bg-yellow-200 
                                        @else bg-red-100 text-red-800 hover:bg-red-200 @endif transition-all duration-200 cursor-pointer">
                                        {{ ucfirst($progress->status) }}
                                    </span>
                                </div>
                            </div>

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
        <!-- Download Receipt/Invoice Section -->
        @if ($appointment->invoice)
            <div class="text-center mt-8">
                <a href="{{ route('patient.downloadInvoice', $appointment->invoice->id) }}"
                   class="bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-700 transition">
                    Download Receipt/Invoice
                </a>
            </div>
        @else
            <div class="text-center mt-8 ">
                <span class="font-semibold py-2 px-4 transition">No prescription provided.</span>
            </div>
        @endif
    </div>
</x-app-layout>
