<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons & Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('jquery.js') }}"></script>

    <!-- Vite & Livewire -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased">

    @auth
        @php
            $user = Auth::user();
            $isTherapist = $user->role === 'therapist';
            $sessionLeft = $user->session_left ?? 0;
        @endphp

        <!-- Navigation Based on Role -->
        @if($user->role === 'admin')
            @include('layouts.admin-navigation')
        @elseif($user->role === 'therapist')
            @include('layouts.therapist-navigation')
        @elseif($user->role === 'patient')
            @include('layouts.patients-navigation')
        @endif
        
    @endauth

    <!-- Page Content -->
    <main id="content-area" class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-28">
        <div class="max-w-7xl mx-auto px-6 py-10 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- About -->
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

                <!-- Contact -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>Email: <a href="mailto:support@mentalwell.com" class="hover:text-indigo-600">support@mentalwell.com</a></li>
                        <li>Phone: +1 (555) 123-4567</li>
                        <li>Address: Cebu City, Philippines</li>
                    </ul>
                </div>

                <!-- Social -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-600 hover:text-indigo-600">
                            <i class="fab fa-facebook fa-lg"></i>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600">
                            <i class="fab fa-twitter fa-lg"></i>
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
