<title>Therapist Details</title>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Therapist Details') }}
        </h2>
    </x-slot>
    
    <div class="max-w-4xl mx-auto my-16">
        <div class="flex justify-start">
            <button id="backButton" class="w-auto mb-6 flex items-center text-sm font-semibold text-gray-900 rounded-md px-3 py-2 transition duration-300 hover:bg-white/30 hover:backdrop-blur-lg border border-transparent hover:border-gray-300">
                <span class="mr-2" aria-hidden="true">&larr;</span>
                Back
            </button>
        </div>
        <div class="bg-white rounded-md p-6 border">
            <!-- Therapist Image -->
            <div class="flex items-center mb-4">
                <img src="https://i.pravatar.cc/150?img={{ $therapist->email }}" alt="Therapist Image" class="w-12 h-12 ring-2 ring-indigo-600 rounded-full object-cover mr-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 capitalize">{{ $therapist->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $therapist->email }}</p>
                </div>
                <button id="openModalButton" type="submit" class="ml-auto text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 py-2 px-4 rounded-lg shadow-md focus:outline-none">
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
                <strong>Awards:</strong>
            </p>
            <ul class="list-disc ml-5 text-gray-600 mb-4">
                <li class="mb-2"> {{ $therapist->therapistInformation->awards ?? 'None' }} </li>
            </ul>
            <!-- Patient Feedbacks Section -->
            <p class="text-gray-600 mb-2">
                <strong>Patient Feedbacks:</strong>
            </p>
            <ul class="list-disc text-gray-600 italic">
                <li class="list-none mb-2">"Dr. {{ $therapist->name }} is extremely patient and understanding. Highly recommend!"</li>
                <li class="list-none mb-2">"Very professional and knowledgeable. Helped me a lot with my anxiety."</li>
                <li class="list-none mb-2">"Great listener and provides actionable advice. My sessions have been life-changing."</li>
            </ul>
        </div>

        <!-- Modal -->
        <div id="static-modal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-md md:max-w-lg">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-md">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b rounded-t">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Book Appointment
                        </h3>
                        <button id="closeModalButton" type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg w-8 h-8 flex justify-center items-center">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form action="{{ route('appointments.store') }}" method="POST" class="p-4 space-y-4">
                        @csrf
                        <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">
                        <input type="hidden" name="receiverID" value="{{ $therapist->id }}">

                        <div>
                            <label for="appointmentDate" class="block text-sm font-medium text-gray-700">Appointment Date</label>
                            <input type="datetime-local" id="appointmentDate" name="datetime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                        </div>

                        <div>
                            <label for="appointmentMessage" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea id="appointmentMessage" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" required></textarea>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center justify-end space-x-3 border-t pt-4">
                            <button id="closeModalButtonFooter" type="button" class="py-2 px-4 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none">
                                Cancel
                            </button>
                            <button id="submitModal" type="submit" class="py-2 px-4 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

<!-- Script for rendering 5 stars -->
<script>
    // Add a click event listener to the Back button
    document.getElementById('backButton').addEventListener('click', function () {
        history.back(); // Navigate to the previous page in browser history
    });

    document.addEventListener("DOMContentLoaded", () => {
        // Find all elements with the data-rating attribute
        document.querySelectorAll("[data-rating]").forEach((ratingElement) => {
            const rating = parseFloat(ratingElement.getAttribute("data-rating"));
            const maxStars = 5;
            let starsHtml = "";

            for (let i = 1; i <= maxStars; i++) {
                // Add filled star for each rating point, else add empty star
                if (i <= rating) {
                    starsHtml += `
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-yellow-500">
                            <path fillRule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clipRule="evenodd" />
                        </svg>
                    `;
                } else {
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
<script>
    // JavaScript to open and close the modal
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');
    const closeModalButtonFooter = document.getElementById('closeModalButtonFooter');
    const modal = document.getElementById('static-modal');

    // Show the modal
    openModalButton.addEventListener('click', function() {
        modal.classList.remove('hidden');
        modal.classList.add('flex'); // Make the modal visible
    });

    // Hide the modal
    closeModalButton.addEventListener('click', function() {
        modal.classList.remove('flex');
        modal.classList.add('hidden'); // Hide the modal
    });

    closeModalButtonFooter.addEventListener('click', function() {
        modal.classList.remove('flex');
        modal.classList.add('hidden'); // Hide the modal
    });

    // Close the modal when clicking outside of modal content
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden'); // Hide the modal
        }
    };
</script>
</x-app-layout>
