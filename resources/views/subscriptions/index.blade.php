<title>Sessions</title>
<x-app-layout>
    <div class="container mx-auto p-6 border-2 mt-4 rounded-lg bg-white shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Your Sessions</h1>
        
        <div class="mb-4">
            <a href="{{ route('subscriptions.plan') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Purchase a Session</a>
        </div>

        @if (session('success'))
            <div class="bg-green-500 text-white p-3 mb-6 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        @if ($subscriptions->isEmpty())
            <div class="bg-gray-100 text-gray-600 p-4 rounded text-center">
                <p>No sessions found. Please purchase a session.</p>
            </div>
        @else
            @foreach ($subscriptions as $subscription)
                <div class="bg-gray-50 shadow-lg rounded-lg p-6 mt-4 border border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-700">{{ $subscription->service_name }}</h2>
                    <p class="mt-2"><strong>Session Added:</strong> {{ $subscription->duration }} Session(s)</p>
                    <p class="mt-1"><strong>Status:</strong> <span class="capitalize">{{ ucfirst($subscription->status) }}</span></p>

                    @if ($subscription->status !== 'active')
                        <div class="flex-auto justify-between mt-4">
                            <a href="{{ url('/patient/subscriptions/' . $subscription->id . '/edit') }}" class="text-black font-semibold hover:bg-green-600 border border-green-500 bg-green-400 rounded-lg px-4 py-2 transition duration-200">Edit</a>
                            <form action="{{ url('/patient/subscriptions/' . $subscription->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-black font-semibold hover:bg-red-600 border border-red-500 rounded-lg bg-red-400 px-4 py-2 transition duration-200 mt-2">Cancel</button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
