<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Admin Dashboard') }}
                    </x-nav-link>

                    <!-- Dropdown for User Management -->
                    <div x-data="{ open: false }" class="relative mt-6 text-sm text-gray-600">
                        <button @click="open = !open" class="flex items-center space-x-1">
                            <span>{{ __('Account Management') }}</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute z-10 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg">
                            <x-nav-link :href="route('admin.patients')" :active="request()->routeIs('admin.patients')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200">
                                {{ __('Patients') }}
                            </x-nav-link>
                            <x-nav-link :href="route('admin.therapists')" :active="request()->routeIs('admin.therapists')" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200">
                                {{ __('Therapists') }}
                            </x-nav-link>
                        </div>
                    </div>

                    <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                        {{ __('View Reports') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.contentmng')" :active="request()->routeIs('admin.reports')">
                        {{ __('Content Management') }}
                    </x-nav-link>
                </div>
            </div>

            <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="ml-1 h-4 w-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                            Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</nav>
