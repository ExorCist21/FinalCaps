<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'MentalWell') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    html {
        scroll-behavior: smooth;
    }
  </style>
</head>
<body class="bg-white">

    <button id="scrollToTop" class="fixed bottom-6 right-6 z-50 hidden bg-indigo-600 text-white p-3 rounded-full shadow-md hover:bg-indigo-500 focus:outline-none">
        <svg class="h-6 w-6"  fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
        </svg>
    </button>
      
    <!-- Header -->
    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center justify-between p-6 lg:px-8 max-w-7xl mx-auto" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="flex items-center mb-4">
                    <img src="{{ asset('images/logo1.png') }}" class="h-8 w-auto" alt="MentalWell Logo">
                    <span class="ml-2 text-lg font-bold text-gray-900">MentalWell</span>
                </a>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="/#about" 
                    class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                    About
                </a>
                <a href="/#features" 
                    class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                    Features
                </a>
                <a href="/#pricing" 
                    class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                    Pricing
                </a>
                <a href="/#contact" 
                    class="text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                    Contact
                </a>
            </div>
            
            <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-4">
                <div class="hidden lg:flex lg:flex-1 lg:justify-end relative">
                    <!-- Login Button -->
                    <a href="{{ route('login') }}"
                        class="mr-4 text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                        Login
                    </a>
                    <!-- Dropdown Trigger -->
                    <div class="relative group">
                        <button class="text-sm font-semibold text-gray-100 bg-indigo-600 rounded-md px-3 py-2 hover:bg-indigo-500">
                            Register
                        </button>
                        <!-- Dropdown Menu -->
                        <div
                            class="absolute right-0 mt-1 hidden w-48 bg-white shadow-lg rounded-md border border-gray-200 group-hover:block z-50">
                            <a href="{{ route('patient.register') }}" 
                                class="block px-4 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-100 transition">
                                Register as Patient
                            </a>
                            <a href="{{ route('therapist.register') }}" 
                                class="block px-4 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-100 transition">
                                Apply as Therapist
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </nav>
    </header>
    
    {{ $slot }}

    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
        <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>

    <footer class="bg-white border-t border-gray-200">
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

</body>

<script>
    // Get the button
    const scrollToTopBtn = document.getElementById("scrollToTop");
  
    // Add scroll event listener
    window.addEventListener("scroll", () => {
      if (window.scrollY > 200) { // Show button after scrolling 200px
        scrollToTopBtn.classList.remove("hidden");
      } else {
        scrollToTopBtn.classList.add("hidden");
      }
    });
  
    // Add click event listener to the button
    scrollToTopBtn.addEventListener("click", () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth"
      });
    });
</script>
  
</html>