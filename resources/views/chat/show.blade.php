<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <!-- Header -->
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold">Chat with {{ $therapist->name }}</h2>
                <p class="text-gray-500 text-sm">You're chatting with your therapist for appointment {{ $appointment->id }}</p>
            </div>

            <!-- Therapist Info -->
            <div class="p-4 flex items-center space-x-4">
                <img src="{{ asset('images/pp.png') }}" alt="{{ $therapist->name }}" class="w-24 h-24 rounded-full">
                <div>
                    <h3 class="text-xl font-semibold">{{ $therapist->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $therapist->specialization }}</p>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="p-4 border-t">
                @foreach($messages as $message)
                    <div class="{{ $message->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">
                        <p>{{ $message->content }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Send Message -->
            <div class="p-4">
                <form action="{{ route('chat.send', $conversation->id) }}" method="POST">
                    @csrf
                    <textarea name="message" class="w-full p-2 border rounded-md" rows="4" placeholder="Type your message..."></textarea>
                    <button type="submit" class="w-full py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-200 mt-4">Send</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
