<title>Therapist Account</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold mb-4">Therapist</h2>
        
        @if ($therapists->isEmpty())
            <p>No therapist found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Therapist ID</th>    
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($therapists as $therapist)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->email }}</td>
                                @if ($therapist->isActive == 1)
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <form action="{{ route('therapist.deactivate', $therapist->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-black font-bold hover:bg-red-600 border-2 p-2 rounded-md bg-red-400 border-red-400">Deactivate</button>
                                    </form>
                                </td>
                                @else
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <form action="{{ route('therapist.activate', $therapist->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-black font-bold hover:bg-green-600 border-2 p-2 rounded-md bg-green-400 border-green-400">Activate</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
