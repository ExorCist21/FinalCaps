<title>Appointments</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Available Therapists') }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-r from-pastel-blue-100 via-pastel-pink-100 to-pastel-lavender-100 py-8"> <!-- Pastel Gradient Background -->
        <div class="max-w-7xl mx-auto px-6">

            <!-- Filter Section -->
            <form method="GET" action="{{ route('patients.bookappointments') }}" class="mb-6">
                <div class="flex flex-col md:flex-row md:items-end md:space-x-6 space-y-4 md:space-y-0">
                    <!-- Profession Filter -->
                    <div>
                        <label for="occupation" class="block text-sm font-medium text-gray-800 mb-1">Filter by Profession</label>
                        <select name="occupation" id="occupation"
                                class="border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-48 p-2">
                            <option value="">All Categories</option>
                            @foreach ($occuOptions as $occupation)
                                <option value="{{ $occupation }}" {{ request('occupation') == $occupation ? 'selected' : '' }}>
                                    {{ ucfirst($occupation) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Expertise Filter -->
                    <div>
                        <label for="expertise" class="block text-sm font-medium text-gray-800 mb-1">Filter by Specialty</label>
                        <select name="expertise" id="expertise"
                                class="border border-gray-300 text-gray-700 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-48 p-2">
                            <option value="">All Expertise</option>
                            @foreach ($expertiseOptions as $option)
                                <option value="{{ $option }}" {{ request('expertise') == $option ? 'selected' : '' }}>
                                    {{ ucfirst($option) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="mt-1 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring focus:ring-indigo-300">
                            Filter
                        </button>
                    </div>
                </div>
            </form>

            <h5 class="text-start text-2xl font-semibold text-gray-800 mb-6">Available Therapists</h5>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse ($therapists as $therapist)
                    <!-- Therapist Card -->
                    <div class="bg-white rounded-xl border border-pastel-gray-200 flex flex-col items-center text-center shadow-lg hover:shadow-xl transition-transform duration-300 transform hover:scale-105 hover:rotate-1 cursor-pointer">
                        <a href="{{ route('patients.therapist-details', $therapist->id) }}" class="block w-full py-6 hover:bg-pastel-pink-50 hover:text-gray-800">
                            <!-- Therapist Image -->
                            <div class="mb-6">
                                @if ($therapist->therapistInformation && $therapist->therapistInformation->image_picture)
                                    <img src="{{ asset('storage/' . $therapist->therapistInformation->image_picture) }}" 
                                        alt="Profile Picture" 
                                        class="h-20 w-20 rounded-full object-cover mx-auto hover:opacity-80 transition">
                                @else
                                    <div class="h-20 w-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        N/A
                                    </div>
                                @endif
                            </div>
                            <!-- Therapist Details -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $therapist->first_name }} {{ $therapist->last_name }}</h3>
                                <p class="text-sm text-gray-600">{{ $therapist->email }}</p>
                            </div>
                            <hr class="my-4 mx-8 border-pastel-gray-300"/>
                            <p class="text-gray-600 mb-2">
                                <strong>Expertise:</strong> {{ $therapist->therapistInformation->expertise ?? 'Not available' }}
                            </p>
                            <p class="text-sm text-gray-700 mb-2">
                                <!-- Rating Section -->
                                <div class="flex justify-center">
                                    @if($therapist->feedback->count() > 0)
                                        <div class="flex justify-center" data-rating="{{ round($therapist->feedback->avg('rating'), 1) }}">
                                            <!-- Stars will be rendered here -->
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500">No feedback yet</p>
                                    @endif
                                </div>
                            </p>
                        </a>
                    </div>
                @empty
                    <p class="text-gray-600 col-span-full text-center text-lg">No therapists found for the selected category.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Script for rendering 5 stars -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("[data-rating]").forEach((ratingElement) => {
                const rating = parseFloat(ratingElement.getAttribute("data-rating"));
                const maxStars = 5;
                let starsHtml = "";

                // Loop through and add stars
                for (let i = 1; i <= maxStars; i++) {
                    if (i <= rating) {
                        // Filled star
                        starsHtml += ` 
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-500">
                                <path fillRule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clipRule="evenodd" />
                            </svg>
                        `;
                    } else {
                        // Empty star
                        starsHtml += ` 
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-5 h-5 text-gray-300">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                            </svg>
                        `;
                    }
                }

                // Inject the stars into the element
                ratingElement.innerHTML = starsHtml;
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            @if(session('success'))
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonColor: "#4CAF50",
                    confirmButtonText: "OK"
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    icon: "error",
                    confirmButtonColor: "#E53935",
                    confirmButtonText: "OK"
                });
            @endif
        });
    </script>
</x-app-layout>
