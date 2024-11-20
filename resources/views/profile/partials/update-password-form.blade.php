<section class="space-y-6">
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password Field -->
        <div>
            <label for="current-password" class="block text-sm font-medium text-gray-800 mb-1">
                {{ __('Current Password') }}
            </label>
            <input 
                id="current-password" 
                name="current_password" 
                type="password" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                autocomplete="current-password" 
                placeholder="Enter your current password"
            />
            @error('current_password')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- New Password Field -->
        <div>
            <label for="new-password" class="block text-sm font-medium text-gray-800 mb-1">
                {{ __('New Password') }}
            </label>
            <input 
                id="new-password" 
                name="password" 
                type="password" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                autocomplete="new-password" 
                placeholder="Enter your new password"
            />
            @error('password')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password Field -->
        <div>
            <label for="password-confirmation" class="block text-sm font-medium text-gray-800 mb-1">
                {{ __('Confirm Password') }}
            </label>
            <input 
                id="password-confirmation" 
                name="password_confirmation" 
                type="password" 
                class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                autocomplete="new-password" 
                placeholder="Confirm your new password"
            />
            @error('password_confirmation')
                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Save Button -->
        <div class="flex justify-center">
            <button 
                type="submit" 
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            >
                {{ __('Save Changes') }}
            </button>
        </div>
    </form>
</section>
