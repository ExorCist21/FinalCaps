<title>Update Subscription</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Subscription</h1>
        <form action="{{ route('subscriptions.update', $subscription->id) }}" method="POST" class="bg-white shadow rounded-lg p-4">
            @csrf
            @method('PUT') <!-- Use PUT for update -->

            <!-- Service Name -->
            <div class="mb-4">
                <label for="service_name" class="block text-sm font-medium">Service Name:</label>
                <input type="text" name="service_name" id="service_name" value="{{ old('service_name', $subscription->service_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
                @error('service_name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Duration -->
            <div class="mb-4">
                <label for="duration" class="block text-sm font-medium">Duration (Months):</label>
                <select name="duration" id="duration" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
                    <option value="3" {{ old('duration', $subscription->duration) == 3 ? 'selected' : '' }}>3 Months</option>
                    <option value="6" {{ old('duration', $subscription->duration) == 6 ? 'selected' : '' }}>6 Months</option>
                    <option value="12" {{ old('duration', $subscription->duration) == 12 ? 'selected' : '' }}>12 Months</option>
                </select>
                @error('duration')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Update</button>
        </form>
    </div>
</x-app-layout>
