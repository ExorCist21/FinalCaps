<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('patients.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('patients.dashboard')" :active="request()->routeIs('patient.dashboard')">
                        {{ __(' Dashboard') }}
                    </x-nav-link>

                    <!-- Add more patient-specific links here -->
                    <x-nav-link :href="route('patients.appointment')" :active="request()->routeIs('patients.appointment')"> 
                        {{ __('Appointments') }}
                    </x-nav-link>
                    <x-nav-link :href="route('chat.index')" :active="request()->routeIs('chat.index')">
                        {{ __('Chats') }}
                    </x-nav-link>

                    <x-nav-link :href="route('patient.session')" :active="request()->routeIs('patient.session')">
                        {{ __('View Session') }}
                    </x-nav-link>

                    <x-nav-link>
                        {{ __('Progress') }}
                    </x-nav-link>
                    <x-nav-link :href="route('subscriptions.index')" :active="request()->routeIs('subscriptions.*')">
                        {{ __('Subscriptions') }}
                    </x-nav-link>
                    

                </div>
            </div>

            @include('layouts.partials.user-settings') <!-- Include user settings dropdown -->
        </div>
    </div>
</nav>
