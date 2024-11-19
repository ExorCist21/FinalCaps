<title>Therapist Background</title>
<x-app-layout>
    <div class="max-w-4xl mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Your Therapist Background</h1>

        @if ($therapistInformation)
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Profile Details</h2>

                <div class="mb-4">
                    <p><strong>Clinic Name:</strong> {{ $therapistInformation->clinic_name }}</p>
                </div>

                <div class="mb-4">
                    <p><strong>Awards:</strong> {{ $therapistInformation->awards }}</p>
                </div>

                <div class="mb-4">
                    <p><strong>Expertise:</strong> {{ $therapistInformation->expertise }}</p>
                </div>
            </div>
        @else
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
                <p>No background information available yet. <a href="{{ route('therapist.profile') }}" class="text-blue-600 hover:underline">Please complete your profile.</a></p>
            </div>
        @endif
    </div>
</x-app-layout>
