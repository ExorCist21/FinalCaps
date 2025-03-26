<title>Therapist Account</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <!-- Header and Search Bar -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Therapist Accounts</h2>
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Search therapists..." 
                    class="px-4 py-2 w-64 border rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-3 w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19a8 8 0 100-16 8 8 0 000 16zm0 0l4 4"></path>
                </svg>
            </div>
        </div>

        <!-- No Therapists Found -->
        @if ($therapists->isEmpty())
            <div class="bg-gray-100 text-gray-600 p-4 rounded-lg text-center shadow-md">
                <p class="text-lg font-semibold">No therapists found.</p>
            </div>
        @else
            <!-- Therapist Table -->
            <div class="overflow-x-auto border rounded-lg shadow-lg">
                <table class="min-w-full table-auto border-collapse divide-y divide-gray-200" id="therapistTable">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium uppercase">Therapist ID</th>    
                            <th class="px-6 py-3 text-xs font-medium uppercase">Name</th>
                            <th class="px-6 py-3 text-xs font-medium uppercase">Email</th>
                            <th class="px-6 py-3 text-xs font-medium uppercase">Expertise</th>
                            <th class="px-6 py-3 text-xs font-medium uppercase">License No.</th>
                            <th class="px-6 py-3 text-xs font-medium uppercase">Contact No.</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($therapists as $therapist)
                            <tr class="hover:bg-indigo-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->therapistInformation->expertise ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->therapistInformation->awards }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $therapist->therapistInformation->contact_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if ($therapist->isActive == 1)
                                        <form action="{{ route('therapist.deactivate', $therapist->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                class="px-4 py-2 text-sm font-semibold text-white bg-red-500 rounded-md hover:bg-red-600 transition duration-300">
                                                Deactivate
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('therapist.activate', $therapist->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                class="px-4 py-2 text-sm font-semibold text-white bg-green-500 rounded-md hover:bg-green-600 transition duration-300">
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
        // Therapist Search Functionality
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

            @if(session('success'))
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonColor: "#4CAF50",
                confirmButtonText: "OK"
            });
            @endif

            @if(session('error'))
                Swal.fire({
                    title: "Error!",
                    text: "{{ session('error') }}",
                    icon: "error",
                    confirmButtonColor: "#E53935",
                    confirmButtonText: "OK"
                });
            @endif
        });
    </script>
</x-app-layout>
