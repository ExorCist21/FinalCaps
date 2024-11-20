<title>Sessions</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Your Sessions') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-8">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-800">
                {{ __('Available Sessions') }}
            </h3>
            <a href="{{ route('subscriptions.plan') }}" 
               class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline focus:ring-2 focus:ring-indigo-500">
                Purchase a Session
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-6 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- No Sessions Available -->
        @if ($subscriptions->isEmpty())
            <div class="text-center text-gray-600 bg-gray-100 p-8 rounded-lg shadow-md">
                <p class="text-lg font-semibold">No sessions found.</p>
                <p class="mt-2 text-sm">Please purchase a session to get started.</p>
            </div>
        @else
            <!-- Sessions List -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($subscriptions as $subscription)
                    <div class="bg-white border rounded-lg transition-shadow duration-300 p-6">
                        <h2 class="text-lg font-bold text-gray-800 capitalize">{{ $subscription->service_name }}</h2>
                        <p class="mt-3 text-sm text-gray-600">
                            <strong>Duration:</strong> {{ $subscription->duration }} Month(s)
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            <strong>Status:</strong>
                            <span class="{{ $subscription->status === 'active' ? 'text-green-600' : 'text-red-500' }}">
                                {{ ucfirst($subscription->status) }}
                            </span>
                        </p>

                        <!-- Action Buttons -->
                        @if ($subscription->status !== 'active')
                            <div class="flex justify-between items-center mt-4">
                                <a href="{{ url('/patient/subscriptions/' . $subscription->id . '/edit') }}" 
                                   class="rounded-md bg-green-500 px-4 py-2 text-sm font-semibold text-white hover:bg-green-600 transition duration-200">
                                    Edit
                                </a>
                                <form action="{{ url('/patient/subscriptions/' . $subscription->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="rounded-md bg-red-500 px-4 py-2 text-sm font-semibold text-white hover:bg-red-600 transition duration-200">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
