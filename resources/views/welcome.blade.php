<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MentalWell</title>
    
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    <style>
        /* Custom gradient circle background */
        .circle1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,182,193,0.5), transparent);
            border-radius: 50%;
            top: 20%;
            left: 15%;
            z-index: -1;
        }
        .circle2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(173,216,230,0.5), transparent);
            border-radius: 50%;
            top: 60%;
            right: 10%;
            z-index: -1;
        }
        /* Glow effect on button hover */
        .glow-button:hover {
            box-shadow: 0 0 15px rgba(100, 149, 237, 0.6);
        }
    </style>
</head>
<body class="antialiased min-h-screen bg-gradient-to-r from-pink-50 to-blue-50 relative overflow-hidden">

    <!-- Gradient Circles -->
    <div class="circle1"></div>
    <div class="circle2"></div>

    <!-- Navbar/Login Links -->
    <div class="fixed top-0 right-0 p-6 z-10">
        @if (Route::has('login'))
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-pink-600 hover:text-pink-800 font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-pink-600 hover:text-pink-800 font-semibold">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('view.select-register') }}" class="ml-4 text-pink-600 hover:text-pink-800 font-semibold">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>

    <!-- Hero Section -->
    <section class="flex items-center justify-center min-h-screen px-6 py-5 text-center">
        <div class="max-w-2xl mx-auto bg-white p-10 rounded-lg shadow-lg border border-blue-100 transition transform hover:scale-105">
            <h1 class="text-4xl font-bold text-pink-400 mb-4">
                Empowering <span class="text-blue-400">Your Mental Wellness</span>
            </h1>
            <p class="text-lg text-gray-600 mb-4">Talk to a Therapist from the comfort of your home</p>
            
            <div class="flex items-center justify-center gap-4 mb-6">
                <p class="flex items-center text-blue-400">
                    <i class="fas fa-laptop-house fa-lg mr-2"></i> 
                    Choose your preferred mode of Counseling
                </p>
            </div>
            
            <a href="{{ route('view.select-register') }}">
                <button class="bg-blue-400 text-white font-semibold py-2 px-4 rounded-full shadow-md hover:bg-blue-500 glow-button transition duration-200">
                    Start Your Journey
                </button>
            </a>
        </div>
    </section>

</body>
</html>
