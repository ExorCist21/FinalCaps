<x-guest-layout>
    <div class="min-h-screen sm:min-h-[400px] h-auto flex flex-col items-center justify-center bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 relative sm:py-10">
        <!-- Background image -->
        <div class="absolute inset-0 -z-10 opacity-30 bg-cover" style="background-image: url('https://source.unsplash.com/featured/?wellness,nature');"></div>

        <!-- Welcome Text -->
        <div class="text-center mb-10">
            <h1 class="text-5xl font-extrabold text-blue-500 drop-shadow-lg">Welcome to MentalWell</h1>
            <p class="text-xl text-gray-600 mt-2">Choose Your Registration Type Below</p>
        </div>

        <!-- Registration Options Container -->
        <div class="bg-white bg-opacity-80 shadow-xl rounded-xl p-12 w-full max-w-lg border border-gray-200 backdrop-blur-md">
            <div class="flex flex-col space-y-6">
                <!-- Register as Patient Button -->
                <a href="{{ route('patient.register') }}" 
                class="text-lg font-bold flex py-4 justify-center bg-pink-300 text-gray-800 rounded-lg shadow-lg transition duration-300 transform hover:scale-105 hover:bg-pink-400">
                    Register as Patient
                </a>

                <!-- Register as Therapist Button -->
                <a href="{{ route('therapist.register') }}" 
                class="text-lg font-bold flex py-4 justify-center bg-blue-300 text-gray-800 rounded-lg shadow-lg transition duration-300 transform hover:scale-105 hover:bg-blue-400">
                    Register as Therapist
                </a>
            </div>
        </div>

        <!-- Login Link -->
        <div class="mt-10">
            <a href="{{ route('login') }}" class="text-lg font-semibold text-blue-700 underline hover:text-blue-800">
                Already signed up? Log in here
            </a>
        </div>
    </div>
</x-guest-layout>
