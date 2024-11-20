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
            <div class="hidden lg:flex lg:gap-x-5 justify-center items-center flex-grow">
                <a href="{{ route('admin.dashboard') }}" 
                class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                Dashboard
                </a>
                <div x-data="{ open: false }" class="relative text-sm text-gray-600">
                    <button @click="open = !open" class="flex items-center space-x-1 px-3 py-2 text-sm font-semibold text-gray-900 rounded-md transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                        <span>{{ __('Account Management') }}</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg">
                        <a href="{{ route('admin.patients') }}" class="block px-4 py-2 text-sm text-gray-900">
                            {{ __('Patients') }}
                        </a>
                        <a href="{{ route('admin.therapists') }}" class="block px-4 py-2 text-sm text-gray-900">
                            {{ __('Therapists') }}
                        </a>
                    </div>
                </div>
                    <a href="{{ route('admin.contentmng') }}" 
                        class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                        Content Management
                    </a>
                    <a href="{{ route('admin.subscribe') }}" 
                        class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                        Subscription
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
