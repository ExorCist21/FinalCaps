<title>Message with {{$patient->name}} </title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <!-- Chat Header -->
            <div class="p-4 border-b border-gray-200 flex items-center">
                <img 
                    src="{{ asset('images/pp.png') }}" 
                    alt="{{ $patient->name }}" 
                    class="w-12 h-12 rounded-full mr-4">
                <h2 class="text-lg font-semibold">{{ $patient->name }}</h2>
            </div>

            <!-- Chat Messages -->
            <div id="chat-box" class="p-4 h-96 overflow-y-scroll bg-gray-100">
                @forelse($messages as $message)
                    <div class="mb-4">
                        <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="p-3 rounded-lg shadow-md max-w-xs {{ $message->sender_id == auth()->id() ? 'bg-gray-300 text-gray-800' : 'bg-blue-500 text-white' }}">
                                {{ $message->body }}
                            </div>
                        </div>
                        <span class="text-sm text-gray-500 {{ $message->sender_id == auth()->id() ? 'text-right block' : '' }}">
                            {{ $message->sender_id == auth()->id() ? 'You' : $patient->name }} - {{ $message->created_at->format('H:i A') }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500">No messages yet. Start the conversation!</p>
                @endforelse
            </div>

            <!-- Input Box -->
            <form id="chat-form" action="{{ route('chat.send', $conversation->id) }}" method="POST" class="p-4 border-t border-gray-200">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                <div class="flex">
                    <input 
                        type="text" 
                        name="message" 
                        id="message" 
                        placeholder="Type your message..." 
                        class="flex-grow border rounded-l-lg px-4 py-2 focus:outline-none"
                    >
                    <button 
                        type="submit" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600 focus:outline-none">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
