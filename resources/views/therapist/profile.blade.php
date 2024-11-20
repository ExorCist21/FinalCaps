<title>Complete Profile</title>
<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Complete Your Profile</h1>

        <form action="{{ route('therapist.updateProfile') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Clinic Name -->
            <div class="mb-4">
                <label for="clinic_name" class="block text-sm font-medium text-gray-700">Clinic Name</label>
                <input type="text" name="clinic_name" id="clinic_name" class="mt-1 block w-full">
            </div>

            <!-- Awards -->
            <div class="mb-4">
                <label for="awards" class="block text-sm font-medium text-gray-700">Awards</label>
                <select name="awards" id="awards" class="mt-1 block w-full">
                    <option value="">Select an Award</option>
                    <option value="Best Therapist of the Year">Best Therapist of the Year</option>
                    <option value="Most Compassionate Therapist">Most Compassionate Therapist</option>
                    <option value="Outstanding Achievement in Mental Health">Outstanding Achievement in Mental Health</option>
                    <option value="Certified Cognitive Behavioral Therapist">Certified Cognitive Behavioral Therapist</option>
                    <option value="none">None</option>
                </select>
            </div>

            <!-- Expertise -->
            <div class="mb-4">
                <label for="expertise" class="block text-sm font-medium text-gray-700">Expertise</label>
                <input type="text" name="expertise" id="expertise" class="mt-1 block w-full">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                    Save Profile
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
