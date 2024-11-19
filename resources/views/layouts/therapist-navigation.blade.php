<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('therapist.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('therapist.dashboard')" :active="request()->routeIs('therapist.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Add more therapist-specific links here -->
                    <x-nav-link :href="route('therapist.appointment')" :active="request()->routeIs('therapist.appointment')">
                        {{ __('Appointment') }}
                    </x-nav-link>

                    <x-nav-link :href="route('therapist.chats')" :active="request()->routeIs('therapist.chats')">
                        {{ __('Chats') }}
                    </x-nav-link>

                    <x-nav-link>
                        {{ __('View Session') }}
                    </x-nav-link>

                    <x-nav-link>
                        {{ __('Progress') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- User Settings Dropdown -->
<div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="relative">
                    <i class="fa-regular fa-bell font-semibold text-gray-500 hover:text-orange-500 cursor-pointer"></i>
                    <!-- Red dot for new notifications -->
                    <span id="notification-dot" class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full" style="display: none;"></span>
                    <!-- Notification Dropdown -->
                    <div id="notification-dropdown" class="border absolute right-0 mt-2 w-96 bg-white rounded-md shadow-lg py-2 z-50 hidden">
                        <h2 class="px-4 py-2 text-lg font-semibold text-gray-800 border-b">Notifications</h2>
                        <div id="notification-list" class="max-h-80">
                            <p class="px-4 py-2 text-gray-800">No new notifications.</p>
                        </div>
                        <button id="see-previous-btn" class="px-4 py-2 w-full text-center text-blue-600 hover:bg-gray-100 hidden">See previous notifications</button>
                    </div>
                </div>

    <!-- Settings Dropdown -->
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                <div>{{ Auth::user()->name }}</div>
                <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </x-slot>

        <x-slot name="content">
            <x-dropdown-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-dropdown-link>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>

<!-- Notification Dropdown (Hidden by default) -->
<div id="notification-dropdown" class="absolute right-0 mt-2 w-60 bg-white shadow-lg rounded-lg hidden z-10">
    <div id="notification-list">
        <!-- Notifications will appear here -->
    </div>
    <div class="p-2 text-center">
        <button id="clear-notifications" class="text-sm text-blue-500">Clear All</button>
    </div>
</div>

<script>
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
                                if (notification.type === 'appointment') {
                                    notificationMessage.innerHTML = 'Patient ' + '<strong>' + notification.data + '</strong> has booked.';         
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
            const baseNegotiationUrl = '/therapist/appointment';  // base path for therapist appointments

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
            } else if (notification.type === 'appointment') {
                return '/therapist/appointment';  // Ensure absolute path with leading slash
            } else if (notification.type === 'feedback') {
                return '/appointment';  // This could be adjusted based on your requirement
            }

            return '/therapist/dashboard'; // Default URL if no specific match is found
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


        </div>
    </div>
</nav>
