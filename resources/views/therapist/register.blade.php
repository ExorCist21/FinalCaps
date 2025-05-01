<title>Sign up as Therapist</title>
<x-guest-layout>
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
        <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
    <div class="flex min-h-screen flex-col mt-10 sm:mt-5 justify-center px-6 py-12 lg:px-8">
        <!-- Logo and Header -->
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-14 w-auto" src="{{ asset('images/logo1.png') }}" alt="MentalWell">
            <h2 class="mt-5 text-center text-2xl/9 font-bold tracking-tight text-gray-900">
                {{ __('Therapist Application Form') }}
            </h2>
        </div>

        <!-- Form -->
        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-md">
            <form method="POST" action="{{ route('therapist.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Name and Email in One Row -->
                <div class="flex flex-col sm:flex-row sm:space-x-4">
                    <!-- Name -->
                    <div class="w-full sm:w-1/2 mb-4 sm:mb-0">
                        <label for="name" class="block text-sm font-medium text-gray-900">Full Name</label>
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

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-900">Contact/Telephone No.</label>
                    <div class="mt-2">
                        <input type="text" id="contact_number" name="contact_number"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                </div>

                <!-- Occupation Dropdown -->
                <div>
                    <label for="occupation" class="block text-sm font-medium text-gray-900">Profession</label>
                    <div class="mt-2">
                        <select id="occupation" name="occupation"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 bg-white shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            <option value="">Select Profession</option>
                            <option value="Psychologist" {{ old('occupation') == 'Psychologist' ? 'selected' : '' }}>Psychologist</option>
                            <option value="Psychiatrist" {{ old('occupation') == 'Psychiatrist' ? 'selected' : '' }}>Psychiatrist</option>
                            <option value="Counselor" {{ old('occupation') == 'Counselor' ? 'selected' : '' }}>Counselor</option>
                            <option value="Social Worker" {{ old('occupation') == 'Social Worker' ? 'selected' : '' }}>Social Worker</option>
                            <option value="Life Coach" {{ old('occupation') == 'Life Coach' ? 'selected' : '' }}>Life Coach</option>
                            <option value="Behavioral Specialist" {{ old('occupation') == 'Behavioral Specialist' ? 'selected' : '' }}>Behavioral Specialist</option>
                            <option value="Clinical Psychologist" {{ old('occupation') == 'Clinical Psychologist' ? 'selected' : '' }}>Clinical Psychologist</option>
                            <option value="Mental Health Nurse" {{ old('occupation') == 'Mental Health Nurse' ? 'selected' : '' }}>Mental Health Nurse</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                </div>

                <!-- Expertise Dropdown -->
                <div>
                    <label for="expertise" class="block text-sm font-medium text-gray-900">Expertise</label>
                    <div class="mt-2">
                        <select id="expertise" name="expertise"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 bg-white shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                            <option value="">Select Expertise</option>
                            <option value="Anxiety" {{ old('expertise') == 'Anxiety' ? 'selected' : '' }}>Anxiety</option>
                            <option value="Mental Health" {{ old('expertise') == 'Mental Health' ? 'selected' : '' }}>Mental Health</option>
                            <option value="Stress" {{ old('expertise') == 'Stress' ? 'selected' : '' }}>Stress</option>
                            <option value="Counseling" {{ old('expertise') == 'Counseling' ? 'selected' : '' }}>Counseling</option>
                            <option value="Child Psychology" {{ old('expertise') == 'Child Psychology' ? 'selected' : '' }}>Child Psychology</option>
                            <option value="Marriage Counseling" {{ old('expertise') == 'Marriage Counseling' ? 'selected' : '' }}>Marriage Counseling</option>
                            <option value="Anger Management" {{ old('expertise') == 'Anger Management' ? 'selected' : '' }}>Anger Management</option>
                            <option value="Psychiatry" {{ old('expertise') == 'Psychiatry' ? 'selected' : '' }}>Psychiatry</option>
                            <option value="Addiction Recovery" {{ old('expertise') == 'Addiction Recovery' ? 'selected' : '' }}>Addiction Recovery</option>
                            <option value="Eating Disorders" {{ old('expertise') == 'Eating Disorders' ? 'selected' : '' }}>Eating Disorders</option>
                            <option value="OCD" {{ old('expertise') == 'OCD' ? 'selected' : '' }}>OCD</option>
                            <option value="Panic Disorders" {{ old('expertise') == 'Panic Disorders' ? 'selected' : '' }}>Panic Disorders</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('expertise')" class="mt-2" />
                </div>

                <!-- Awards -->
                <div>
                    <label for="awards" class="block text-sm font-medium text-gray-900">License Number:</label>
                    <div class="mt-2">
                        <input type="text" id="awards" name="awards"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('awards')" class="mt-2" />
                </div>

                <!-- Clinic Name -->
                <div>
                    <label for="clinic_name" class="block text-sm font-medium text-gray-900">Clinic Name </label>
                    <div class="mt-2">
                        <input type="text" id="clinic_name" name="clinic_name"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    </div>
                    <x-input-error :messages="$errors->get('clinic_name')" class="mt-2" />
                </div>

                <div>
                    <label for="image_picture" class="block text-sm font-medium text-gray-900">Upload Image</label>
                    <div class="mt-2">
                        <input type="file" id="image_picture" name="image_picture"
                            class="block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-600 file:text-white
                                    hover:file:bg-indigo-500">
                    </div>
                    <x-input-error :messages="$errors->get('image_picture')" class="mt-2" />
                </div>

                <!-- Certificates Upload -->
                <div>
                    <label for="certificates" class="block text-sm font-medium text-gray-900">Upload Certificates (PDF, DOCX, etc.)</label>
                    <div class="mt-2">
                        <input type="file" id="certificates" name="certificates[]" multiple
                            class="block w-full text-sm text-gray-900 file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0 file:text-sm file:font-semibold
                                file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                        <div id="selected-files" class="mt-2 space-y-2"></div>
                    </div>
                    <x-input-error :messages="$errors->get('certificates')" class="mt-2" />
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
    <script>
    const fileInput = document.getElementById('certificates');
    const fileListDisplay = document.getElementById('selected-files');
    let selectedFiles = [];

    fileInput.addEventListener('change', function (e) {
        selectedFiles = Array.from(this.files);

        renderFileList();
    });

    function renderFileList() {
        fileListDisplay.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const fileWrapper = document.createElement('div');
            fileWrapper.className = 'flex items-center justify-between bg-gray-100 px-3 py-2 rounded-md';

            const fileName = document.createElement('span');
            fileName.className = 'text-sm text-gray-700 truncate max-w-xs';
            fileName.textContent = file.name;

            const removeBtn = document.createElement('button');
            removeBtn.className = 'text-red-500 hover:text-red-700 ml-2';
            removeBtn.innerHTML = '&times;';
            removeBtn.onclick = () => {
                selectedFiles.splice(index, 1);
                updateFileInput();
                renderFileList();
            };

            fileWrapper.appendChild(fileName);
            fileWrapper.appendChild(removeBtn);
            fileListDisplay.appendChild(fileWrapper);
        });
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
</script>

</x-guest-layout>
