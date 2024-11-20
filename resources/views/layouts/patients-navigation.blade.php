<nav x-data="{ open: false }" class="bg-white mb-28">
    <!-- Main Header -->
    <header class="absolute inset-x-0 top-0 z-50 border-b">
        <nav class="flex items-center justify-between p-6 lg:px-8 max-w-7xl mx-auto" aria-label="Global">
            <!-- Logo -->
            <div class="flex lg:flex-1">
                <a href="{{ route('patients.dashboard') }}" class="flex items-center">
                    <img src="https://i.ibb.co/mC0RNNS/M-1-removebg-preview.png" class="h-8 w-auto" alt="MentalWell Logo">
                    <span class="ml-2 text-lg font-bold text-gray-900">MentalWell</span>
                </a>
            </div>

            <!-- Centered Navigation Links -->
            <div class="hidden lg:flex lg:gap-x-5 justify-center flex-grow">
                <a href="{{ route('patients.dashboard') }}" 
                   class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                   Dashboard
                </a>
                <a href="{{ route('patients.appointment') }}" 
                   class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                   Appointments
                </a>
                <a href="{{ route('patients.bookappointments') }}" 
                   class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                   Therapists
                </a>
                <a href="{{ route('patient.session') }}" 
                   class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                   Activity
                </a>
                <a href="{{ route('patient.progress') }}" 
                   class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                   Progress
                </a>
                <a href="{{ route('subscriptions.index') }}" 
                   class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                   Buy Sessions
                </a>
            </div>

            <!-- Right-Aligned Notification and User Dropdown -->
            <div class="flex items-center gap-4 lg:flex lg:flex-1 lg:justify-end">
                <a href="{{ route('chat.index') }}" class="text-gray-500 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                    </svg>
                </a>
                
                <!-- Notification Icon -->
                <div class="relative">
                    <button class="relative text-gray-500 hover:text-gray-900" id="notification-icon">
                        <i class="fa-regular fa-bell text-xl"></i>
                        <!-- Red dot for new notifications -->
                        <span id="notification-dot" class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full" style="display: none;"></span>
                    </button>
                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="border absolute right-0 mt-2 w-96 bg-white rounded-md shadow-lg py-2 z-50 hidden">
                        <h2 class="px-4 py-2 text-lg font-semibold text-gray-800 border-b">Notifications</h2>
                        <div id="notification-list" class="max-h-80">
                            <p class="px-4 py-2 text-gray-800">No new notifications.</p>
                        </div>
                        <button id="see-previous-btn" class="px-4 py-2 w-full text-center text-blue-600 hover:bg-gray-100 hidden">See previous notifications</button>
                    </div>
                </div>

                <!-- User Settings Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-gray-500 hover:text-gray-900">
                        <i class="fa-regular fa-user-circle text-xl"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            <a href="{{ route('profile.edit') }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 capitalize">
                                {{ Auth::user()->name }} Account
                            </a>    
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</nav>

<div class="flex justify-start max-w-7xl mx-auto">
    <button id="backButton" class="w-auto mb-6 flex items-center text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
        <span class="mr-2" aria-hidden="true">&larr;</span>
        Back
    </button>
</div>

<script>
    // Add a click event listener to the Back button
    document.getElementById('backButton').addEventListener('click', function () {
        history.back(); // Navigate to the previous page in browser history
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        const notificationIcon = document.querySelector('.fa-bell');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationDot = document.getElementById('notification-dot');
        const notificationList = document.getElementById('notification-list');
        const seePreviousBtn = document.getElementById('see-previous-btn');

        let offset = 0;
        let hasPrevious = false;

        function loadNotifications() {
                fetch(`/notifications?offset=${offset}&limit=8`)
                    .then(response => response.json())
                    .then(data => {
                        const unreadNotifications = data.filter(notification => notification.read_at === null);

                        // Show or hide red dot based on unread notifications
                        if (unreadNotifications.length > 0) {
                            notificationDot.style.display = 'inline-block';  // Show the red dot
                        } else {
                            notificationDot.style.display = 'none';  // Hide the red dot if no unread notifications
                        }
                        if (data.length > 0) {
                            if (offset === 0) {
                                notificationList.innerHTML = ''; // Clear placeholder on first load
                            }

                            data.forEach(notification => {
                                const notificationLink = document.createElement('a');
                                notificationLink.classList.add('block', 'px-4', 'py-2', 'text-gray-800', 'hover:bg-gray-100', 'cursor-pointer');

                                // Set background based on read status
                                if (notification.read_at === null) {
                                    notificationLink.classList.add('bg-gray-200'); // Unread - gray background
                                } else {
                                    notificationLink.classList.add('bg-white'); // Read - white background
                                }

                                notificationLink.href = getNotificationUrl(notification);
                                notificationLink.setAttribute('data-id', notification.notificationID);

                                // Add click event for marking as read and redirect
                                notificationLink.addEventListener('click', function (event) {
                                    event.preventDefault();
                                    const url = this.href;
                                    const notificationId = this.getAttribute('data-id');
                                    markAsRead(notificationId, url);
                                });
                                
                                const notificationMessage = document.createElement('div');
                                // Customize the message based on notification type
                                if (notification.type === 'appointment_approved') {
                                    notificationMessage.innerHTML = '<strong>' + notification.data + '</strong> has approved your booking.';         
                                } else if (notification.type === 'appointment_disapproved') {
                                    notificationMessage.innerHTML = '<strong>' + notification.data + '</strong> disapproved your booking.';         
                                } else {
                                    notificationMessage.textContent = notification.description;  // Default message
                                }

                                const notificationDate = document.createElement('span');
                                notificationDate.classList.add('text-gray-400', 'text-sm');
                                notificationDate.textContent = new Date(notification.updated_at).toLocaleString();

                                notificationLink.appendChild(notificationMessage);
                                notificationLink.appendChild(notificationDate);

                                notificationList.appendChild(notificationLink);
                            });

                            // Show "See previous notifications" button if there are more notifications
                            if (data.length === 8) {
                                seePreviousBtn.style.display = 'block';
                                hasPrevious = true; // Previous notifications exist
                            } else {
                                seePreviousBtn.style.display = 'none';
                                hasPrevious = false; // No previous notifications
                            }

                            offset += data.length; // Increase the offset
                        } else if (offset === 0) {
                            notificationList.innerHTML = '<p class="px-4 py-2 text-gray-800">No new notifications.</p>';
                        }
                    })
                    .catch(error => console.error('Error loading notifications:', error));
            }


            // Event listener for "See previous notifications" button
            seePreviousBtn.addEventListener('click', function () {
                // Enable scrolling when this button is clicked
                notificationList.classList.add('max-h-96');
                notificationList.style.overflowY = 'auto'; // Allow scrolling
                loadNotifications();
            });

            // Show/hide the dropdown on bell icon click
            notificationIcon.addEventListener('click', function () {
                notificationDropdown.classList.toggle('hidden');
                // Reset icon color if dropdown is closed
                if (notificationDropdown.classList.contains('hidden')) {
                    notificationIcon.classList.remove('text-orange-500'); // Remove highlight if dropdown is closed
                } else if (hasPrevious) {
                    // Reset the overflow property when dropdown is opened again
                    notificationList.classList.remove('max-h-96');
                    notificationList.style.overflowY = 'hidden'; // Disable scrolling until button is clicked
                }
            });

            // Hide dropdown on outside click
            document.addEventListener('click', function (event) {
                if (!notificationIcon.contains(event.target) && !notificationDropdown.contains(event.target)) {
                    notificationDropdown.classList.add('hidden');
                    notificationIcon.classList.remove('text-orange-500'); // Remove highlight if clicked outside
                }
            });

        // Function to generate the notification URL based on type
        function getNotificationUrl(notification) {
            const baseNegotiationUrl = '/patient/appointment';  // base path for therapist appointments

            // Handle the case where the notification type requires an appointmentID
            if (notification.type === 'message') {
                let data;
                
                // Try to parse the notification data if it's valid JSON
                try {
                    data = JSON.parse(notification.data);
                } catch (e) {
                    console.error('Error parsing notification data:', e);
                    return baseNegotiationUrl;  // Return a default URL if parsing fails
                }

                // If the appointmentID exists, redirect to the specific appointment
                if (data && data.appointmentID) {
                    return `${baseNegotiationUrl}/${data.appointmentID}`;  // Corrected URL format
                } else {
                    return baseNegotiationUrl;  // Return the base appointment URL if no appointmentID
                }
            } else if (notification.type === 'appointment_approved') {
                return '/patient/appointment';  // Ensure absolute path with leading slash
            } else if (notification.type === 'appointment_disapproved') {
                return '/patient/appointment';  // Ensure absolute path with leading slash
            } else if (notification.type === 'feedback') {
                return 'patient/appointment';  // This could be adjusted based on your requirement
            }

            return '/patient/dashboard'; // Default URL if no specific match is found
        }

        // AJAX function to mark a notification as read
        function markAsRead(notificationId, redirectUrl) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ read_at: new Date() })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Notification marked as read:', data);
                // Redirect to the target page after marking the notification as read
                window.location.href = redirectUrl;
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
        }
        loadNotifications();
    });
</script>
