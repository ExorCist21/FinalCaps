<title>Sign up as Therapist</title>
<x-guest-layout>
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
    <div class="flex min-h-screen flex-col mt-10 sm:mt-5 justify-center px-6 py-12 lg:px-8">
        <!-- Logo and Header -->
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-14 w-auto" src="https://i.ibb.co/mC0RNNS/M-1-removebg-preview.png" alt="MentalWell">
            <h2 class="mt-5 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
                {{ __('Therapist Application Form') }}
            </h2>
        </div>

        <!-- Form -->
        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-md">
            <form method="POST" action="{{ route('therapist.store') }}" class="space-y-6">
                @csrf

                <!-- Name and Email in One Row -->
                <div class="flex flex-col sm:flex-row sm:space-x-4">
                    <!-- Name -->
                    <div class="w-full sm:w-1/2 mb-4 sm:mb-0">
                        <label for="name" class="block text-sm font-medium text-gray-900">Name</label>
                        <div class="mt-2">
                            <input type="text" id="name" name="name" autofocus
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="w-full sm:w-1/2">
                        <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                        <div class="mt-2">
                            <input type="email" id="email" name="email"
                                   class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                    <div class="mt-2">
                        <input type="password" id="password" name="password"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-900">Confirm Password</label>
                    <div class="mt-2">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Expertise -->
                <div>
                    <label for="expertise" class="block text-sm font-medium text-gray-900">Expertise</label>
                    <div class="mt-2">
                        <input type="text" id="expertise" name="expertise"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('expertise')" class="mt-2" />
                </div>

                <!-- Awards -->
                <div>
                    <label for="awards" class="block text-sm font-medium text-gray-900">Awards</label>
                    <div class="mt-2">
                        <select name="awards" id="awards" class="p-2 mt-1 block w-full">
                            <option value="">Select an Award</option>
                            <option value="Best Therapist of the Year">Best Therapist of the Year</option>
                            <option value="Most Compassionate Therapist">Most Compassionate Therapist</option>
                            <option value="Outstanding Achievement in Mental Health">Outstanding Achievement in Mental Health</option>
                            <option value="Certified Cognitive Behavioral Therapist">Certified Cognitive Behavioral Therapist</option>
                            <option value="none">None</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('awards')" class="mt-2" />
                </div>

                <!-- Clinic Name -->
                <div>
                    <label for="clinic_name" class="block text-sm font-medium text-gray-900">Clinic Name (Optional)</label>
                    <div class="mt-2">
                        <input type="text" id="clinic_name" name="clinic_name"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('clinic_name')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                        Apply as Therapist
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Already signed up?
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Log in</a>
            </p>
        </div>
    </div>
</x-guest-layout>
