<title>MentalWell Chatbot</title>
<x-app-layout>
    <div class="pt-10 pb-10 flex justify-center items-center min-h-80 bg-gray-50">
        <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">AI Chatbot Support</h2>

            <!-- Chatbox Container -->
            <div id="chatbox" class="p-4 bg-gray-100 rounded-lg shadow-inner mb-4 h-96 overflow-y-auto">
                <p><strong class="text-indigo-600">MentalWell:</strong> Hi! How can I assist you today?</p>
            </div>

            <!-- User Input -->
            <div class="flex items-center space-x-2">
                <input type="text" id="userMessage" class="w-full p-2 border rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-indigo-600" placeholder="Type your message..." />
                <button class="bg-indigo-600 text-white py-2 px-4 rounded-lg text-sm hover:bg-indigo-700 focus:outline-none" onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>

    <script>
        function sendMessage() {
            let userMessage = document.getElementById('userMessage').value;
            if (userMessage.trim() === '') return;

            let chatbox = document.getElementById('chatbox');
            chatbox.innerHTML += `<p><strong class="text-gray-800">You:</strong> ${userMessage}</p>`;

            fetch("{{ route('send.message') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: userMessage })
            })
            .then(response => response.json())
            .then(data => {
                chatbox.innerHTML += `<p><strong class="text-indigo-600">MentalWell:</strong> ${data.reply}</p>`;
                chatbox.scrollTop = chatbox.scrollHeight;  // Auto-scroll to the latest message
            });

            document.getElementById('userMessage').value = ''; // Clear input field
        }
    </script>
</x-app-layout>
