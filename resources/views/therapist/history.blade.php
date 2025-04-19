<title>Appointment and Feedback History</title>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 text-center">
            {{ __('Appointment & Feedback History') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6 space-y-12">

        <!-- Appointment History Section -->
        <section>
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800">Appointment History</h3>
                <div class="w-20 h-1 bg-indigo-500 rounded mt-2"></div>
            </div>

            @if($completedAppointments->isEmpty())
                <div class="text-center text-gray-500 py-16">
                    <p>No completed appointments yet.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($completedAppointments as $appointment)
                        <div class="bg-white border border-gray-200 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="mb-4">
                                <h4 class="text-xl font-semibold text-gray-900 capitalize">{{ $appointment->patient->name ?? 'N/A' }}</h4>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->datetime)->format('F j, Y g:i A') }}</p>
                            </div>

                            <div class="text-sm space-y-2 text-gray-700">
                                <p><span class="font-bold">Session:</span> {{ $appointment->meeting_type }}</p>
                                <p><span class="font-bold">Session Type:</span> {{ $appointment->description }}</p>

                                @if($appointment->progress->isNotEmpty())
                                    @php $progress = $appointment->progress->sortByDesc('created_at')->first(); @endphp
                                    <div class="pt-3 border-t border-gray-100">
                                        <p><span class="font-bold">Status:</span> {{ $progress->status }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Feedback Section -->
        <section>
            <div class="mb-8 mt-16">
                <h3 class="text-2xl font-bold text-gray-800">Patient Feedbacks</h3>
                <div class="w-20 h-1 bg-indigo-500 rounded mt-2"></div>
            </div>

            @if($therapistFeedback->isEmpty())
                <div class="text-center text-gray-500 py-16">
                    <p>No feedbacks available yet.</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($therapistFeedback as $feedback)
                        <div class="bg-white border border-gray-200 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-lg font-semibold text-gray-900 capitalize">{{ $feedback->patient->name ?? 'Unknown' }}</h4>
                                <span class="text-yellow-400 font-bold">{{ $feedback->rating }}/5 ★</span>
                            </div>

                            <p class="text-gray-700 text-sm">{{ $feedback->feedback }}</p>

                            <p class="text-xs text-gray-400 mt-4">{{ $feedback->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
</x-app-layout>
