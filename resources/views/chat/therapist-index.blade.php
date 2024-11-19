<title>Chats</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md flex">
            <!-- Patient List (Left Column) -->
            <div class="w-1/3 border-r">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold">Booked Patients</h2>
                    <p class="text-gray-500 text-sm">Click on a patient to start chatting.</p>
                </div>
                <div class="p-4">
                    @forelse($appointments as $appointment)
                        <div class="mb-4">
                            <a 
                                href="#" 
                                class="flex items-center p-3 bg-gray-100 hover:bg-gray-200 rounded-lg shadow-md transition patient-item"
                                data-patient-id="{{ $appointment->patient->id }}">
                                <img 
                                    src="{{ asset('images/pp.png') }}" 
                                    alt="{{ $appointment->patient->name }}" 
                                    class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <h3 class="text-lg font-semibold capitalize">{{ $appointment->patient->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $appointment->description }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-500">No patients found. Schedule an appointment to connect with a patient.</p>
                    @endforelse
                </div>
            </div>

            <!-- Chat Window (Right Column) -->
            <div class="w-2/3">
                <div id="chat-container" class="hidden">
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-gray-200 flex items-center">
                        <img 
                            id="patient-avatar" 
                            src="{{ asset('images/pp.png') }}" 
                            alt="Patient Avatar" 
                            class="w-12 h-12 rounded-full mr-4">
                        <h2 id="patient-name" class="text-lg font-semibold">Patient Name</h2>
                    </div>

                    <!-- Chat Messages -->
                    <div id="chat-box" class="p-4 h-96 overflow-y-scroll bg-gray-100"></div>

                    <!-- Input Box -->
                    <form id="chat-form" class="p-4 border-t border-gray-200">
                        <div class="flex">
                            <input 
                                type="text" 
                                id="messageInput" 
                                placeholder="Type your message..." 
                                class="flex-grow border rounded-l-lg px-4 py-2 focus:outline-none">
                            <button 
                                type="submit" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600 focus:outline-none">
                                Send
                            </button>
                        </div>
                    </form>
                </div>
                <div id="no-chat-selected" class="p-4 text-center text-gray-500">
                    Select a patient to start chatting.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const chatContainer = document.getElementById('chat-container');
        const noChatSelected = document.getElementById('no-chat-selected');
        const patientItems = document.querySelectorAll('.patient-item');
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('messageInput');
        let fetchUrl = null;
        let sendMessageUrl = null;
        let lastMessageId = 0; // Track the last message ID
        let pollInterval = null; // Interval for polling

        // Stop polling for real-time messages
        function stopPolling() {
            if (pollInterval) {
                clearInterval(pollInterval);
                pollInterval = null;
            }
        }

        // Start polling for real-time messages
        function startPolling() {
            if (!pollInterval && fetchUrl) {
                pollInterval = setInterval(fetchMessages, 3000); // Fetch messages every 3 seconds
            }
        }

        // Handle selecting a patient
        patientItems.forEach(item => {
            item.addEventListener('click', function () {
                stopPolling(); // Stop polling for any previous conversation

                const patientId = this.getAttribute('data-patient-id');
                if (!patientId) {
                    console.error('Patient ID not found for the selected item.');
                    return;
                }

                // Update chat container header details
                document.getElementById('patient-avatar').src = this.querySelector('img').src;
                document.getElementById('patient-name').textContent = this.querySelector('h3').textContent;

                // Update URLs for fetching and sending messages
                fetchUrl = `/therapist/chat/fetch/${patientId}`;
                sendMessageUrl = `/therapist/chat/send/${patientId}`;
                lastMessageId = 0; // Reset lastMessageId for new conversation

                // Show chat container and hide placeholder
                chatContainer.classList.remove('hidden');
                noChatSelected.classList.add('hidden');

                // Fetch messages for the selected patient
                fetchMessages();

                // Start polling for real-time updates
                startPolling();
            });
        });

        // Fetch messages from the server
        function fetchMessages() {
            if (!fetchUrl) return;

            fetch(`${fetchUrl}?lastMessageId=${lastMessageId}`)
                .then(response => response.json())
                .then(messages => {
                    if (messages.length > 0) {
                        messages.forEach(message => {
                            const isSender = message.sender_id == {{ auth()->id() }};
                            const messageDiv = document.createElement('div');
                            messageDiv.classList.add('mb-4');
                            messageDiv.innerHTML = `
                                <div class="flex ${isSender ? 'justify-end' : 'justify-start'}">
                                    <div class="p-3 rounded-lg shadow-md max-w-xs ${isSender ? 'bg-gray-300 text-gray-800' : 'bg-blue-500 text-white'}">
                                        ${message.body}
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500 ${isSender ? 'text-right' : 'text-left'}">
                                    ${new Date(message.created_at).toLocaleString()}
                                </span>
                            `;
                            chatBox.appendChild(messageDiv);
                        });
                        chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom
                        lastMessageId = messages[messages.length - 1].id; // Update lastMessageId
                    }
                })
                .catch(error => console.error('Error fetching messages:', error));
        }

        // Handle sending a message
        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('message', messageInput.value);

            fetch(sendMessageUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
                .then(response => response.json())
                .then(() => {
                    messageInput.value = ''; // Clear input
                    fetchMessages(); // Refresh messages
                })
                .catch(error => console.error('Error sending message:', error));
        });

        // Stop polling when navigating away
        window.addEventListener('beforeunload', stopPolling);
    });
    </script>
</x-app-layout>
