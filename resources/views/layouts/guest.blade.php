<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MentalWell') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-pink-100 to-teal-100 dark:from-gray-700 dark:to-gray-800">
        <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0">
            <div class="mb-8">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-teal-500" />
                </a>
            </div>

            <!-- Container with a unique class only for the guest page -->
            <div class="guest-container w-full sm:w-[600px] mt-6 px-6 py-8 sm:py-10 h-auto sm:h-[700px] bg-white dark:bg-gray-800 rounded-lg shadow-xl transform transition-all duration-300 ease-in-out hover:scale-105">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-semibold text-pink-400 dark:text-pink-300">Welcome to MentalWell</h2>
                    <p class="text-lg text-black-600 dark:text-purple-00">Your journey to better mental health starts here.</p>
                </div>

                <!-- Main content -->
                <div class="mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
