<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <!-- Page Header -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-3xl font-semibold text-gray-800">Payment Management</h2>
            <p class="text-gray-600">Manage payments for completed sessions.</p>
        </div>

        <!-- Success or error message -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-md mb-4 shadow-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-md mb-4 shadow-lg">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 6L6 18M6 6l12 12"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Appointments Table -->
        <div class="overflow-hidden bg-white shadow-md rounded-lg mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-indigo-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Therapist Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GCash Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($appointments as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $appointment->appointmentID }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $appointment->therapist->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $appointment->therapist->therapistInformation->gcash_number ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <!-- Check if there is any completed progress -->
                                @if($appointment->progress->isNotEmpty())
                                    <span class="text-green-600 font-semibold">{{ $appointment->progress->first()->status }}</span>
                                @else
                                    <span class="text-yellow-600 font-semibold">Ongoing Progress</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($appointment->payments->isNotEmpty() && $appointment->payments->first()->status === 'Pending') 
                                    <span class="text-yellow-600 font-semibold">Done payment, waiting for approval.</span>
                                @elseif($appointment->payments->isNotEmpty() && $appointment->payments->first()->status === 'Confirmed')
                                    <span class="text-indigo-600 font-semibold">Payment Done</span>
                                @else
                                    <a href="{{ route('admin.showPaymentForm', ['appointmentID' => $appointment->appointmentID]) }}" 
                                       class="text-indigo-600 hover:text-indigo-800 font-semibold transition duration-200">
                                        Send Payment
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
