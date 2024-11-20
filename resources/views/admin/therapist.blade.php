<title>Therapist Account</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Therapist Accounts</h2>
            <div>
                <input type="text" id="searchInput" placeholder="Search therapists..." 
                       class="px-4 py-2 w-64 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>
        </div>

        @if ($therapists->isEmpty())
            <div class="bg-gray-100 text-gray-600 p-4 rounded-lg text-center">
                <p>No therapists found.</p>
            </div>
        @else
            <div class="overflow-x-auto border rounded-lg">
                <table class="min-w-full border-collapse divide-y divide-gray-200" id="therapistTable">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Therapist ID</th>    
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expertise</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($therapists as $therapist)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->expertise ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($therapist->isActive == 1)
                                        <form action="{{ route('therapist.deactivate', $therapist->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-md hover:bg-red-600 transition">
                                                Deactivate
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('therapist.activate', $therapist->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                class="px-4 py-2 text-sm font-semibold text-white bg-green-500 rounded-md hover:bg-green-600 transition">
                                                Activate
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#therapistTable tbody tr');

            searchInput.addEventListener('keyup', function () {
                const searchTerm = searchInput.value.toLowerCase();

                tableRows.forEach(row => {
                    const name = row.cells[1].textContent.toLowerCase();
                    const email = row.cells[2].textContent.toLowerCase();
                    const expertise = row.cells[3].textContent.toLowerCase();

                    if (name.includes(searchTerm) || email.includes(searchTerm) || expertise.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-app-layout>
