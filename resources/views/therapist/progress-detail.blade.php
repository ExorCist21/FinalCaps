<x-app-layout>
<div class="max-w-4xl mx-auto mt-10">
    <div class="flex justify-start">
        <button id="backButton" class="w-auto mb-6 flex items-center text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
        <span class="mr-2" aria-hidden="true">&larr;</span>
            Back
        </button>
    </div>
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Appointment Progress</h1>
    <div class="max-w-4xl mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Health Progress</h1>
        <!-- Progress Timeline -->
        @if ($appointment->progress->isNotEmpty())
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Progress Timeline</h2>
                
                <!-- Iterate through each progress entry -->
                <div class="relative">
                    @foreach ($appointment->progress as $progress)
                        <div class="mb-8">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-blue-500 text-white flex items-center justify-center">
                                        <span class="font-semibold text-lg">{{ $loop->iteration }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-semibold text-lg text-gray-700">{{ ucfirst($progress->mental_condition) }}</h3>
                                        <p class="text-sm text-gray-500">{{ $progress->remarks }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500">{{ $progress->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="absolute left-2 w-1 bg-gray-300 h-full top-10"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
                <p>No progress details are available for this appointment yet.</p>
            </div>
        @endif
    </div>
</x-app-layout>
