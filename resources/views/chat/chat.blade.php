<title>Message with {{$therapist->name}} </title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md">
            <!-- Chat Header -->
            <div class="p-4 border-b border-gray-200 flex items-center">
                <img 
                    src="{{ asset('images/pp.png') }}" 
                    alt="{{ $therapist->name }}" 
                    class="w-12 h-12 rounded-full mr-4">
                <h2 class="text-lg font-semibold">{{ $therapist->name }}</h2>
            </div>

            <!-- Chat Messages -->
            <div id="chat-box" class="p-4 h-96 overflow-y-scroll bg-gray-100">
                @forelse($messages as $message)
                    <div class="mb-4 message-item" data-message-id="{{ $message->id }}">
                        <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="p-3 rounded-lg shadow-md max-w-xs {{ $message->sender_id == auth()->id() ? 'bg-gray-300 text-gray-800' : 'bg-blue-500 text-white' }}">
                                {{ $message->body }}
                            </div>
                        </div>
                        <span class="text-sm text-gray-500 {{ $message->sender_id == auth()->id() ? 'text-right block' : '' }}">
                            {{ $message->sender_id == auth()->id() ? 'You' : $therapist->name }} - {{ $message->created_at->format('H:i A') }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500">No messages yet. Start the conversation!</p>
                @endforelse
            </div>

            <!-- Input Box -->
            <form id="chat-form" action="{{ route('chat.send', $conversation->id) }}" method="POST" enctype="multipart/form-data"  class="p-4 border-t border-gray-200">
                @csrf
                <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">
                <div class="flex">
                    <input 
                        type="text" 
                        name="message" 
                        id="messageInput" 
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatBox = document.getElementById('chat-box');
            const chatForm = document.getElementById('chat-form');
            const messageInput = document.getElementById('messageInput');
            const fetchUrl = "{{ route('chat.fetch', $conversation->id) }}";
            const sendMessageUrl = "{{ route('chat.send', $conversation->id) }}";

            // Fetch new messages
            function fetchMessages() {
                const lastMessageId = document.querySelector('.message-item:last-child')?.dataset?.messageId || 0;

                fetch(fetchUrl + '?lastMessageId=' + lastMessageId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length) {
                            data.forEach(message => {
                                const messageDiv = document.createElement('div');
                                messageDiv.classList.add('mb-4', 'message-item');
                                messageDiv.dataset.messageId = message.id;
                                messageDiv.innerHTML = ` 
                                    <div class="flex ${message.sender_id == {{ auth()->id() }} ? 'justify-end' : 'justify-start'}">
                                        <div class="p-3 rounded-lg shadow-md max-w-xs ${message.sender_id == {{ auth()->id() }} ? 'bg-gray-300 text-gray-800' : 'bg-blue-500 text-white'}">
                                            ${message.body}
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500 ${message.sender_id == {{ auth()->id() }} ? 'text-right block' : ''}">
                                        ${message.sender_id == {{ auth()->id() }} ? 'You' : '{{ $therapist->name }}'} - ${new Date(message.created_at).toLocaleTimeString()}
                                    </span>
                                `;
                                chatBox.appendChild(messageDiv);
                            });
                            chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom
                        }
                    });
            }

            // Submit message
            chatForm.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission behavior
                const formData = new FormData(chatForm);

                fetch(sendMessageUrl, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    // Reset the form and clear the message input explicitly
                    chatForm.reset(); // This resets the entire form including the input fields
                    messageInput.value = ''; // Explicitly clear the input field

                    // Optionally, fetch new messages to update the chat window
                    fetchMessages();
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
            });

            // Scroll to the bottom on page load
            chatBox.scrollTop = chatBox.scrollHeight;

            // Poll for new messages every 3 seconds
            setInterval(fetchMessages, 3000);
        });
    </script>
</x-app-layout>
