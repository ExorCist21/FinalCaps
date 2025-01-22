<title>Therapist Details</title>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Therapist Details') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-md p-6 border">
            <!-- Therapist Image -->
            <div class="flex items-center mb-4">
                <img src="https://i.pravatar.cc/150?img={{ $therapist->email }}" alt="Therapist Image" class="w-12 h-12 ring-2 ring-indigo-600 rounded-full object-cover mr-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $therapist->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $therapist->email }}</p>
                </div>
                <button id="openModalButton" type="button" class="ml-auto text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 py-2 px-4 rounded-lg shadow-md focus:outline-none">
                    Book an Appointment
                </button>
            </div>
            <hr class="my-4"/>
            <p class="text-gray-600 mb-2">
                <strong>Expertise:</strong> {{ $therapist->therapistInformation->expertise ?? 'Not Available' }}
            </p>
            <!-- Ratings with Stars -->
            <div class="flex items-center mb-4">
                <strong class="text-gray-600 mr-2">Ratings:</strong>
                <div class="flex">
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
            </div>
            <!-- Awards Section -->
            <p class="text-gray-600 mb-2">
                <strong>License Number:</strong>
            </p>
            <ul class="list-disc ml-5 text-gray-600 mb-4">
                <li class="mb-2"> {{ $therapist->therapistInformation->awards ?? 'None' }} </li>
            </ul>
            <!-- Patient Feedbacks Section -->
            <p class="text-gray-600 mb-2">
                <strong>Patient Feedbacks:</strong>
            </p>
            <ul class="list-disc text-gray-600 italic">
                <li class="list-none mb-2">
                    <strong>Dr. {{ $therapist->name }}</strong>
                    <ul>
                        @forelse ($therapist->feedback as $feedback)
                            <li class="text-gray-700">- {{ $feedback->feedback }}</li>
                        @empty
                            <li class="text-gray-500">No feedback available.</li>
                        @endforelse
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Modal -->
        <div id="static-modal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-md md:max-w-lg bg-gradient-to-r from-indigo-50 via-blue-50 to-indigo-100 rounded-lg shadow-lg">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-xl overflow-hidden">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 bg-indigo-600 text-white rounded-t-lg shadow-md">
                    <h3 class="text-lg font-semibold">
                        Book Appointment
                    </h3>
                    <button id="closeModalButton" type="button" class="text-gray-300 hover:bg-indigo-700 hover:text-white rounded-lg w-8 h-8 flex justify-center items-center transition-colors duration-200">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span class="sr-only">Close</span>
                    </button>
                </div>

                    <!-- Modal body -->
                    <form action="{{ route('appointments.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">

                        <!-- Appointment Date -->
                        <div class="mb-4">
                            <label for="appointmentDate" class="block text-sm font-medium text-gray-700">Appointment Date</label>
                            <input type="datetime-local" id="appointmentDate" name="datetime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" required>
                        </div>

                        <!-- Message -->
                        <div class="mb-4">
                            <label for="appointmentMessage" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea id="appointmentMessage" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm" required></textarea>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center justify-end space-x-3 border-t pt-4">
                            <button id="closeModalButtonFooter" type="button" class="py-2 px-4 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none transition-all duration-200">
                                Cancel
                            </button>
                            <button id="submitModal" type="submit" class="py-2 px-4 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for no sessions left -->
        <div id="noSessionModal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-md md:max-w-lg">
                <div class="relative bg-white rounded-lg shadow-md">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            No Sessions Left
                        </h3>
                        <p class="text-gray-600 mt-2">You have 0 sessions left to book an appointment. Kindly navigate to the <a href="{{ route('subscriptions.index') }}" class="text-indigo-600">purchase session</a> page to buy more sessions.</p>
                        <div class="mt-4 flex justify-end space-x-3">
                            <button id="closeNoSessionModal" class="py-2 px-4 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- Script for rendering 5 stars -->
<script>
    // Add a click event listener to the Back button
    document.getElementById('backButton')?.addEventListener('click', function () {
        history.back(); // Navigate to the previous page in browser history
    });

    document.addEventListener("DOMContentLoaded", () => {
        // Render star ratings
        document.querySelectorAll("[data-rating]").forEach((ratingElement) => {
            const rating = parseFloat(ratingElement.getAttribute("data-rating")) || 0;
            const maxStars = 5;
            let starsHtml = "";

            for (let i = 1; i <= maxStars; i++) {
                starsHtml += i <= rating
                    ? `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-500">
                            <path fillRule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clipRule="evenodd" />
                       </svg>`
                    : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" class="w-5 h-5 text-gray-300">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                       </svg>`;
            }

            // Inject the stars into the element
            ratingElement.innerHTML = starsHtml;
        });

        // Modal logic
        const openModalButton = document.getElementById('openModalButton');
        const closeModalButton = document.getElementById('closeModalButton');
        const closeModalButtonFooter = document.getElementById('closeModalButtonFooter');
        const closeNoSessionModal = document.getElementById('closeNoSessionModal');
        const modal = document.getElementById('static-modal');
        const noSessionModal = document.getElementById('noSessionModal');
        const sessionLeft = parseInt("{{ $session_left }}") || 0; // Use the session count from your server-side variable

        if (openModalButton) {
            openModalButton.addEventListener('click', function () {
                if (sessionLeft === 0) {
                    noSessionModal?.classList.remove('hidden');
                    noSessionModal?.classList.add('flex'); // Show no session modal
                } else {
                    modal?.classList.remove('hidden');
                    modal?.classList.add('flex'); // Show booking modal
                }
            });
        }

        if (closeModalButton) {
            closeModalButton.addEventListener('click', function () {
                modal?.classList.remove('flex');
                modal?.classList.add('hidden');
            });
        }

        if (closeModalButtonFooter) {
            closeModalButtonFooter.addEventListener('click', function () {
                modal?.classList.remove('flex');
                modal?.classList.add('hidden');
            });
        }

        if (closeNoSessionModal) {
            closeNoSessionModal.addEventListener('click', function () {
                noSessionModal?.classList.remove('flex');
                noSessionModal?.classList.add('hidden');
            });
        }

        // Close modals when clicking outside
        window.onclick = function (event) {
            if (event.target === modal) {
                modal?.classList.remove('flex');
                modal?.classList.add('hidden');
            }
            if (event.target === noSessionModal) {
                noSessionModal?.classList.remove('flex');
                noSessionModal?.classList.add('hidden');
            }
        };
    });
</script>
<style>
    #static-modal {
        transition: opacity 0.3s ease, visibility 0s linear 0.3s;
    }
    #static-modal.flex {
        opacity: 1;
        visibility: visible;
        transition: opacity 0.3s ease, visibility 0s;
    }
    #static-modal.hidden {
        opacity: 0;
        visibility: hidden;
    }
</style>

</x-app-layout>
