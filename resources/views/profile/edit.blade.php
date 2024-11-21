<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-10">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-3">
            Profile Settings
        </h2>

        <!-- Success or Error Messages -->
        @if (session('status'))
            <div class="p-4 mb-6 bg-green-50 border border-green-200 text-green-800 rounded-md">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->updatePassword->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-md">
            @foreach ($errors->updatePassword->all() as $error)
                    <p>{{ $error }}</p>
            @endforeach
            </div>
        @endif

        <div class="p-6 bg-gray-50 rounded-lg border">
            <h3 class="text-lg font-medium text-gray-800 mb-2">Profile Information</h3>
            <p class="text-sm text-gray-600 mb-4">
                Update your account's profile information and email address.
            </p>
            <div>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-lg border">
            <h3 class="text-lg font-medium text-gray-800 mb-2">Update Password</h3>
            <p class="text-sm text-gray-600 mb-4">
                Ensure your account is using a long, random password to stay secure.
            </p>
            <div>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 bg-gray-50 rounded-lg border">
            <h3 class="text-lg font-medium text-red-600 mb-2">Delete Account</h3>
            <p class="text-sm text-gray-600 mb-4">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
            </p>
            <div>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
