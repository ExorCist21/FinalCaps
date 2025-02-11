<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Scripts -->
    <script src="{{ asset('jquery.js') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
        @if (Auth::user()->role === 'admin')
            @include('layouts.admin-navigation')
        @elseif (Auth::user()->role === 'therapist')
            @include('layouts.therapist-navigation')
        @elseif (Auth::user()->role === 'patient')
            @include('layouts.patients-navigation')
        @endif

        <!-- Page Content -->
        <main id="content-area" class="min-h-screen">
            {{ $slot }} 
        </main>

        <footer class="bg-white border-t border-gray-200 mt-28">
            <div class="max-w-7xl mx-auto px-6 py-10 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- About Section -->
                <div>
                <a href="#" class="flex items-center mb-4">
                    <img src="{{ asset('images/logo1.png') }}" class="h-8 w-auto" alt="MentalWell Logo">
                    <span class="ml-2 text-lg font-bold text-gray-900">MentalWell</span>
                </a>
                <p class="text-sm text-gray-600">
                    Enhancing mental health awareness and access to care in Cebu City through innovative digital solutions.
                </p>
                </div>
        
                <!-- Quick Links -->
                <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="#about" class="text-sm text-gray-600 hover:text-indigo-600 transition">About</a></li>
                    <li><a href="#features" class="text-sm text-gray-600 hover:text-indigo-600 transition">Features</a></li>
                    <li><a href="#significance" class="text-sm text-gray-600 hover:text-indigo-600 transition">Pricing</a></li>
                    <li><a href="#contact" class="text-sm text-gray-600 hover:text-indigo-600 transition">Contact</a></li>
                </ul>
                </div>
        
                <!-- Contact Section -->
                <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Us</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li><span>Email: <a href="mailto:support@mentalwell.com" class="hover:text-indigo-600">support@mentalwell.com</a></span></li>
                    <li><span>Phone: +1 (555) 123-4567</span></li>
                    <li><span>Address: Cebu City, Philippines</span></li>
                </ul>
                </div>
        
                <!-- Social Media -->
                <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-600 hover:text-indigo-600">
                    <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22.54 0H1.46C.65 0 0 .65 0 1.46v21.08C0 23.35.65 24 1.46 24h11.4V14.69H9.8v-3.62h3.06V8.13c0-3.04 1.84-4.7 4.55-4.7 1.29 0 2.4.1 2.72.14v3.14h-1.87c-1.47 0-1.75.7-1.75 1.73v2.26h3.5l-.46 3.62h-3.04V24h5.96c.81 0 1.46-.65 1.46-1.46V1.46C24 .65 23.35 0 22.54 0"></path></svg>
                    </a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600">
                    <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M24 4.56c-.88.39-1.83.66-2.82.78a4.92 4.92 0 0 0 2.15-2.71 9.84 9.84 0 0 1-3.13 1.2 4.92 4.92 0 0 0-8.38 4.48 13.94 13.94 0 0 1-10.11-5.14 4.92 4.92 0 0 0 1.52 6.56c-.81-.02-1.56-.25-2.22-.61v.06a4.92 4.92 0 0 0 3.95 4.83c-.7.2-1.43.24-2.17.09a4.92 4.92 0 0 0 4.6 3.42A9.87 9.87 0 0 1 0 19.54a13.92 13.92 0 0 0 7.56 2.21c9.06 0 14-7.5 14-14V6.14c.96-.69 1.8-1.55 2.46-2.54z"></path></svg>
                    </a>
                </div>
                </div>
            </div>
            <div class="mt-10 border-t border-gray-200 pt-8 text-center">
                <p class="text-sm text-gray-500">© 2024 MentalWell. All rights reserved.</p>
            </div>
            </div>
        </footer>
    @livewireScripts
</body>
</html>
