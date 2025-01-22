<nav x-data="{ open: false }" class="bg-white mb-28">
    <!-- Main Header -->
    <header class="absolute inset-x-0 top-0 z-50 border-b">
        <nav class="flex items-center justify-between p-6 lg:px-8 max-w-7xl mx-auto" aria-label="Global">
            <!-- Logo -->
            <div class="flex lg:flex-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="https://i.ibb.co/mC0RNNS/M-1-removebg-preview.png" class="h-8 w-auto" alt="MentalWell Logo">
                    <span class="ml-2 text-lg font-bold text-gray-900">MentalWell</span>
                </a>
            </div>

            <!-- Centered Navigation Links -->
            <div class="hidden lg:flex lg:gap-x-5 justify-center items-center flex-grow">
    <!-- Dashboard Link -->
    <a href="{{ route('admin.dashboard') }}" 
       class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 transform hover:bg-white/30 hover:backdrop-blur-lg hover:scale-105 border border-transparent hover:border-gray-300 focus:outline-none">
        Dashboard
    </a>

    <!-- Accounts Dropdown -->
    <div x-data="{ open: false }" class="relative text-sm text-gray-600">
        <button @click="open = !open" 
                class="flex items-center space-x-1 px-3 py-2 text-sm font-semibold text-gray-900 rounded-md transition duration-300 transform hover:bg-white/30 hover:backdrop-blur-lg hover:scale-105 border border-transparent hover:border-gray-300 focus:outline-none">
            <span>{{ __('Accounts') }}</span>
            <svg class="w-4 h-4 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
        <div x-show="open" @click.away="open = false" 
             class="absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg transition-all duration-300 ease-in-out transform opacity-0 scale-95 origin-top" 
             :class="{ 'opacity-100 scale-100': open }">
            <a href="{{ route('admin.patients') }}" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 transition duration-200">
                {{ __('Patients') }}
            </a>
            <a href="{{ route('admin.therapists') }}" class="block px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 transition duration-200">
                {{ __('Therapists') }}
            </a>
        </div>
    </div>

        <!-- Content Management Link -->
        <a href="{{ route('admin.contentmng') }}" 
            class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 transform hover:bg-white/30 hover:backdrop-blur-lg hover:scale-105 border border-transparent hover:border-gray-300 focus:outline-none">
                Contents
            </a>

            <!-- Sessions Link -->
            <a href="{{ route('admin.subscribe') }}" 
            class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 transform hover:bg-white/30 hover:backdrop-blur-lg hover:scale-105 border border-transparent hover:border-gray-300 focus:outline-none">
                Sessions
            </a>

            <!-- Payments Link -->
            <a href="{{ route('admin.appointments') }}" 
            class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 transform hover:bg-white/30 hover:backdrop-blur-lg hover:scale-105 border border-transparent hover:border-gray-300 focus:outline-none">
                Payments
            </a>

            <!-- Reports Link -->
            <a href="{{ route('admin.reports.index') }}" 
            class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 transform hover:bg-white/30 hover:backdrop-blur-lg hover:scale-105 border border-transparent hover:border-gray-300 focus:outline-none">
                Reports
            </a>
        </div>


            <!-- Right-Aligned Notification and User Dropdown -->
            <div class="flex items-center gap-4 lg:flex lg:flex-1 lg:justify-end">
                
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const notificationIcon = document.getElementById('notification-icon');
    const notificationDropdown = document.getElementById('notification-dropdown');
    const notificationDot = document.getElementById('notification-dot');
    const notificationList = document.getElementById('notification-list');
    const seePreviousBtn = document.getElementById('see-previous-btn');

    let offset = 0; // Tracks loaded notifications
    let hasPrevious = false;

    // Load notifications from the server
    function loadNotifications() {
        fetch(`/notifications?offset=${offset}&limit=8`)
            .then(response => response.json())
            .then(data => {
                const unreadNotifications = data.filter(notification => notification.read_at === null);

                // Show or hide red dot based on unread notifications
                notificationDot.style.display = unreadNotifications.length > 0 ? 'inline-block' : 'none';

                if (data.length > 0) {
                    if (offset === 0) {
                        notificationList.innerHTML = ''; // Clear the list for the first load
                    }

                    data.forEach(notification => {
                        const notificationLink = document.createElement('a');
                        notificationLink.classList.add(
                            'block',
                            'px-4',
                            'py-2',
                            'text-gray-800',
                            'hover:bg-gray-100',
                            'cursor-pointer'
                        );

                        // Style based on read status
                        if (notification.read_at === null) {
                            notificationLink.classList.add('bg-gray-200'); // Unread
                        } else {
                            notificationLink.classList.add('bg-white'); // Read
                        }

                        notificationLink.href = getNotificationUrl(notification);
                        notificationLink.setAttribute('data-id', notification.notificationID);

                        // Mark as read on click
                        notificationLink.addEventListener('click', function (event) {
                            event.preventDefault();
                            const url = this.href;
                            const notificationId = this.getAttribute('data-id');
                            markAsRead(notificationId, url);
                        });

                        const notificationMessage = document.createElement('div');
                        notificationMessage.innerHTML = getNotificationMessage(notification);

                        const notificationDate = document.createElement('span');
                        notificationDate.classList.add('text-gray-400', 'text-sm');
                        notificationDate.textContent = new Date(notification.updated_at).toLocaleString();

                        notificationLink.appendChild(notificationMessage);
                        notificationLink.appendChild(notificationDate);

                        notificationList.appendChild(notificationLink);
                    });

                    // Show "See previous notifications" button if more notifications exist
                    if (data.length === 8) {
                        seePreviousBtn.style.display = 'block';
                        hasPrevious = true;
                    } else {
                        seePreviousBtn.style.display = 'none';
                        hasPrevious = false;
                    }

                    offset += data.length; // Increment offset
                } else if (offset === 0) {
                    notificationList.innerHTML = '<p class="px-4 py-2 text-gray-800">No new notifications.</p>';
                }
            })
            .catch(error => console.error('Error loading notifications:', error));
    }

    // Determine notification message content
    function getNotificationMessage(notification) {
        if (notification.type === 'payment') {
            return 'Patient <strong>' + notification.data + '</strong> has purchased a session.';
        } else if (notification.type === 'appointment_approved') { 
            return 'Appointment for <strong>' + notification.data + '</strong> has been approved.';
        }
        return notification.description || 'You have a new notification.';
    }

    // Generate URL based on notification type
    function getNotificationUrl(notification) {
        if (notification.type === 'payment') {
            return '/admin/subscription';
        } else if (notification.type === 'appointment') {
            return '/admin/appointments';
        } else if (notification.type === 'feedback') {
            return '/feedback';
        }
        return '/dashboard'; // Default URL
    }

    // Mark notification as read and redirect
    function markAsRead(notificationId, redirectUrl) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ read_at: new Date() }),
        })
            .then(response => response.json())
            .then(() => {
                window.location.href = redirectUrl; // Redirect after marking as read
            })
            .catch(error => console.error('Error marking notification as read:', error));
    }

    // Toggle dropdown visibility
    notificationIcon.addEventListener('click', function () {
        notificationDropdown.classList.toggle('hidden');
    });

    // Hide dropdown on outside click
    document.addEventListener('click', function (event) {
        if (!notificationDropdown.contains(event.target) && !notificationIcon.contains(event.target)) {
            notificationDropdown.classList.add('hidden');
        }
    });

    // Load previous notifications on button click
    seePreviousBtn.addEventListener('click', loadNotifications);

    // Initial load
    loadNotifications();
});

</script>