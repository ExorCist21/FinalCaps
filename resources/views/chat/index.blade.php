<title>Chats</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Your Booked Therapists</h2>
                <p class="text-gray-500 text-sm">Click on a therapist to start chatting.</p>
            </div>

            <!-- Therapist List -->
            <div class="p-4">
                @forelse($appointments as $appointment)
                    <div class="mb-4">
                        <a 
                            href="{{ route('chat.show', ['therapist' => $appointment->therapist->id, 'appointment' => $appointment->appointmentID]) }}" 
                            class="flex items-center p-3 bg-gray-100 hover:bg-gray-200 rounded-lg shadow-md transition">
                            <img 
                                src="{{ asset('images/pp.png') }}" 
                                alt="{{ $appointment->therapist->name }}" 
                                class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $appointment->therapist->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $appointment->description }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500">No therapists found. Book an appointment to connect with a therapist.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
