<title>Admin Dashboard</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <!-- Main Content Section -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Dashboard Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white rounded-lg shadow-lg mb-8 p-8">
                <h3 class="text-3xl font-semibold mb-2">{{ __("Welcome, Admin!") }}</h3>
                <p class="text-lg mb-6">{{ __("Manage users, monitor activity, and fine-tune the system settings from this dashboard.") }}</p>
                <a href="#" class="inline-block text-indigo-200 hover:text-white text-sm font-semibold border-b-2 border-transparent hover:border-white transition">
                    Learn More <span class="font-bold">→</span>
                </a>
            </div>

            <!-- Stats and Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Users Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-indigo-500 text-white rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Total Users</h4>
                            <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-300">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Users Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Active Users</h4>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-300">{{ $activeUsers }}</p>
                        </div>
                    </div>
                </div>

                <!-- Inactive Users Card -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-yellow-500 text-white rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12l9 4-9 4-9-4 9-4z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Inactive Users</h4>
                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-300">{{ $inactiveUsers }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics and Activities Section -->
            <div class="mt-12 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Recent Activities</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md p-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Recent User Sign-ups</h4>
                    <ul class="list-disc pl-6 space-y-2 mt-4">
                        @foreach ($recentUsers as $user)
                            <li class="text-gray-700 dark:text-gray-200">{{ $user->name }} - Registered at {{ $user->created_at->format('H:i A') }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
