<title>Patient Dashboard</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Patient Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome, Patient!") }}
                </div>
                <div class="mt-4">
                    <h3 class="text-lg font-semibold">Patient Actions</h3>
                    <ul class="list-disc ml-5">
                        <li><a href="#" class="text-blue-500">View Appointments</a></li>
                        <li><a href="#" class="text-blue-500">Contact Therapist</a></li>
                        <li><a href="#" class="text-blue-500">View Health Records</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
