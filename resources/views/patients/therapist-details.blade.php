<title>Therapist Details</title>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Therapist Details') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto my-16">
        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow">
            <div class="flex flex-col items-center pb-10">
                <!-- Therapist Image -->
                <img src="{{ asset('images/pp.png') }}" alt="image" class="w-24 h-24 mb-4 rounded-full shadow-lg">

                <!-- Therapist Name and Email -->
                <h5 class="mb-1 text-xl font-medium text-gray-900">{{ $therapist->name }}</h5>
                <span class="text-sm text-gray-500">{{ $therapist->email }}</span>

                <!-- Expertise -->
                <p class="text-sm text-gray-700 mt-4">
                    <strong>Expertise:</strong> {{ $therapist->expertise }}
                </p>

                <!-- Ratings -->
                <p class="text-sm text-gray-700">
                    <strong>Ratings:</strong> {{ $therapist->ratings }} / 5
                </p>

                <!-- Additional Therapist Details -->
                <p class="text-sm text-gray-700 mt-4">
                    <strong>Awards:</strong> {{ $therapist->awards }}
                </p>

                <!-- Action Buttons -->
                <div class="flex mt-6 space-x-3 p-2">
                    <!-- Back to Appointments Link -->
                    <a href="{{ route('patients.appointment') }}" class="focus:outline-none text-white bg-slate-400 hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Back to Appointments</a>
                    
                    <!-- Book Appointment Button (trigger the modal) -->
                    <button type="button" class="focus:outline-none text-white bg-green-400 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" id="openModalButton">
                        Book Appointment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="static-modal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Book Appointment
                    </h3>
                    <button id="closeModalButton" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <input type="hidden" name="therapist_id" value="{{ $therapist->id }}">
                    <input type="hidden" name="receiverID" value="{{ $therapist->id }}">
                    <label for="appointmentDate" class="block text-sm font-medium text-gray-700">Appointment Date</label>
                    <input type="datetime-local" id="appointmentDate" name="datetime" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">

                    <label for="appointmentMessage" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea id="appointmentMessage" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>

                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="submitModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    <button id="closeModalButtonFooter" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>

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
