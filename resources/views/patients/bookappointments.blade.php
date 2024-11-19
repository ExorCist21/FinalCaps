<title>Appointments</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Available Therapists') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto my-2">
        <h5 class="text-center text-xl font-semibold text-gray-800">Available Therapists</h5>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 p-2 ">
            @foreach ($therapists as $therapist)
            {{-- Therapist Card --}}
            <div class="bg-white rounded-md border flex flex-col items-center text-center">
                <a href="{{ route('patients.therapist-details', $therapist->id) }}" class="block w-full py-6 hover:bg-gray-50 hover:shadow transition duration-300">
                    <!-- Therapist Image -->
                    <div class="mb-4">
                        <img src="https://i.pravatar.cc/150?img={{ $therapist->email }}" alt="Therapist Image" class="w-16 h-16 ring-2 ring-indigo-600 rounded-full object-cover mx-auto">
                    </div>
                    <!-- Therapist Details -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $therapist->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $therapist->email }}</p>
                    </div>
                    <hr class="my-3 mx-8"/>
                    <p class="text-gray-600 mb-2">
                        <strong>Expertise:</strong> {{ $therapist->therapistInformation->expertise ?? 'Not available' }}
                    </p>
                    <p class="text-sm text-gray-700 mb-2">
                    <div class="flex justify-center">
                        @if($therapist->feedback->count() > 0)
                            <p class="text-sm text-gray-700 mb-2">
                                <div class="flex justify-center" data-rating="{{ round($therapist->feedback->avg('rating'), 1) }}">
                                    <!-- Stars will be rendered here -->
                                </div>
                            </p>
                        @else
                            <p class="text-sm text-gray-700 text-gray-500">No feedback yet</p>
                        @endif
                    </div>
                    </p>
                </a>
            </div>
            @endforeach
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
    </script>
</x-app-layout>
