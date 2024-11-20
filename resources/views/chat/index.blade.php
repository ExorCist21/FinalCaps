<title>Messages</title>
<title>Messages</title>
<x-app-layout>
    <div id="chat-container" class="flex max-w-7xl mx-auto border rounded-lg">
        <!-- Conversation List -->
        <div class="w-1/3 overflow-y-auto max-h-screen border-r border-gray-200 min-h-[600px] max-h-[600px]">
            <h3 class="text-lg font-bold text-gray-700 text-center py-7">Your Connections</h3>
            <div id="conversation-list" class="text-gray-500"></div>
        </div>

        <!-- Chat Window -->
        <div id="chat-window-container" class="w-2/3 bg-white hidden min-h-[600px] max-h-[600px]">
            <!-- Chat Window -->
            <div id="chat-window" class="flex flex-col">
                <!-- Chat Header -->
                <div id="chat-header" class="flex items-center border-b border-gray-300 px-4 py-4">
                    <img
                        id="chat-header-image"
                        src="https://via.placeholder.com/50"
                        alt="User Avatar"
                        class="w-12 h-12 rounded-full mr-4"
                    />
                    <div>
                        <h3 id="chat-header-name" class="text-lg font-semibold text-gray-800">Select a user</h3>
                        <p id="chat-header-email" class="text-sm text-gray-600">Email will appear here</p>
                    </div>
                </div>

                <!-- Messages -->
                <div id="messages" class="flex-grow overflow-y-auto rounded-md p-4 min-h-[440px] max-h-[440px] border-b border-gray-200">
                    <div class="no-data text-gray-500 text-center" id="message-placeholder">Select a conversation to start chatting.</div>
                </div>

                <!-- Message Input -->
                <div class="flex items-center px-4 py-2">
                    <textarea
                        id="message-body"
                        placeholder="Type a message..."
                        class="flex-grow border border-gray-300 rounded-md p-2 mr-4 resize-none focus:outline-none focus:ring focus:ring-indigo-300 disabled:opacity-50 min-h-[50px] max-h-[150px]"
                        disabled
                    ></textarea>
                    <button
                        id="send-message"
                        class="bg-indigo-500 text-white px-6 py-2 rounded-md hover:bg-indigo-600 disabled:opacity-50"
                        disabled
                    >
                        Send
                    </button>
                </div>
            </div>
        </div>

        <!-- Placeholder if no chat is selected -->
        <div id="chat-placeholder" class="w-2/3 flex flex-col items-center justify-center">
            <p class="text-gray-500 text-lg">No chat selected yet. Select a conversation to start chatting.</p>
        </div>
    </div>

    <script>
        let senderId = {{ $userId }}; // Set the logged-in user's ID
        let receiverId = null; // This will be set dynamically when a user is selected

        function fetchConversationList() {
            $('#conversation-list').html('<div class="loading text-gray-500 text-center">Loading conversations...</div>');

            $.ajax({
                url: '/chat/conversation-list',
                method: 'GET',
                data: { sender_id: senderId },
                success: function (users) {
                    $('#conversation-list').empty();

                    if (users.length === 0) {
                        $('#conversation-list').html('<div class="no-data text-gray-500">No conversations found.<br/>Please book an appointment first.</div>');
                        return;
                    }

                    users.forEach(user => {
                        $('#conversation-list').append(
                            `<div class="conversation-item flex items-center pl-10 py-5 cursor-pointer hover:bg-gray-200"
                                data-user-id="${user.id}">
                                <img src="https://i.pravatar.cc/150?img=${user.email}" alt="User Avatar"
                                    class="w-12 h-12 ring-2 ring-indigo-600 rounded-full object-cover mr-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 capitalize">${user.name}</h3>
                                    <p class="text-sm text-gray-600">${user.email}</p>
                                </div>
                            </div>`
                        );
                    });

                    // Attach click event to load chat
                    $('.conversation-item').click(function () {
                        receiverId = $(this).data('user-id');

                        // Fetch user details from the clicked conversation item
                        const userName = $(this).find('h3').text();
                        const userEmail = $(this).find('p').text();
                        const userAvatar = $(this).find('img').attr('src');

                        // Update the Chat Header
                        $('#chat-header-name').text(userName);
                        $('#chat-header-email').text(userEmail);
                        $('#chat-header-image').attr('src', userAvatar);

                        // Show chat window and hide placeholder
                        $('#chat-placeholder').addClass('hidden');
                        $('#chat-window-container').removeClass('hidden');

                        // Enable chat input and load messages
                        loadInitialMessages();
                        $('#message-body').prop('disabled', false);
                        $('#send-message').prop('disabled', false);
                        $('#message-placeholder').hide();
                    });
                },
                error: function () {
                    $('#conversation-list').html('<div class="no-data text-gray-500">Failed to load conversations. Try again later.</div>');
                },
            });
        }

        function loadInitialMessages() {
            if (!receiverId) return; // No receiver selected

            $.ajax({
                url: '/chat/load-initial-messages',
                method: 'GET',
                data: {
                    sender_id: senderId,
                    receiver_id: receiverId,
                },
                success: function(messages) {
                    if (!Array.isArray(messages)) {
                        console.error('Invalid response: Expected an array of messages.');
                        return;
                    }

                    $('#messages').empty(); // Clear the chat window

                    messages.forEach(message => {
                        renderMessage(message); // Append messages
                    });

                    // Auto-scroll to the latest message
                    $('#messages').scrollTop($('#messages')[0].scrollHeight);
                },
                error: function() {
                    console.error('Failed to load initial messages.');
                }
            });
        }

        function fetchUnreadMessages() {
            if (!receiverId) return; // No receiver selected

            $.ajax({
                url: '/chat/fetch-unread-messages',
                method: 'GET',
                data: {
                    sender_id: senderId,
                    receiver_id: receiverId,
                },
                success: function(unreadMessages) {
                    if (unreadMessages.length > 0) {
                        unreadMessages.forEach(message => {
                            renderMessage(message); // Append only new messages
                        });

                        // Auto-scroll to the latest message
                        $('#messages').scrollTop($('#messages')[0].scrollHeight);
                    }
                },
                error: function() {
                    console.error('Failed to fetch unread messages.');
                }
            });
        }

        function renderMessage(message) {
            let alignment = message.sender_id == senderId ? 'text-right' : 'text-left';
            let messageBg = message.sender_id == senderId ? 'bg-indigo-100' : 'bg-gray-200';
            $('#messages').append(
                `<div class="${alignment} my-2">
                    <div class="inline-block ${messageBg} p-2 rounded-lg max-w-xs">
                        <span class="block text-gray-800">${message.body}</span>
                    </div>
                    <small class="block text-gray-500 text-xs mt-1">${new Date(message.created_at).toLocaleString()}</small>
                </div>`
            );
        }

        function sendMessage() {
            let body = $('#message-body').val();
            if (body.trim() === '' || !receiverId) return;

            $.ajax({
                url: '/chat/send-message',
                method: 'POST',
                data: {
                    sender_id: senderId,
                    receiver_id: receiverId,
                    body: body,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is passed
                },
                success: function(response) {
                    $('#message-body').val(''); // Clear input
                    renderMessage(response); // Append the new message directly
                    $('#messages').scrollTop($('#messages')[0].scrollHeight); // Auto-scroll
                },
                error: function(xhr, status, error) {
                    console.error('Error Sending Message:', xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            fetchConversationList(); // Load conversation list on page load

            $('#send-message').click(function() {
                sendMessage();
            });

            $('#message-body').on('keypress', function(e) {
                if (e.which === 13) { // Enter key
                    sendMessage();
                    e.preventDefault(); // Prevent form submission
                }
            });

            // Periodically fetch unread messages
            setInterval(fetchUnreadMessages, 3000);
        });
    </script>
</x-app-layout>
