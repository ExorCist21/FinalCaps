<title>Payment</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800">Payment Management</h2>
        <p class="text-gray-600 mb-4">Manage payments for completed sessions.</p>

        <!-- Success or error message -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Appointments Table -->
        <div class="overflow-hidden bg-white shadow sm:rounded-lg mb-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Therapist Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">GCash Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($appointments as $appointment)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $appointment->appointmentID }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $appointment->therapist->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $appointment->therapist->therapistInformation->gcash_number ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <!-- Check if there is any completed progress -->
                                @if($appointment->progress->isNotEmpty())
                                    {{ $appointment->progress->first()->status }}
                                @else
                                    Ongoing Progress
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($appointment->payments->isNotEmpty() && $appointment->payments->first()->status === 'Pending') 
                                    <span class="text-yellow-600">Done payment, waiting for approval.</span>
                                @elseif($appointment->payments->isNotEmpty() && $appointment->payments->first()->status === 'Confirmed')
                                    <span  
                                    class="text-indigo-600 hover:text-indigo-900">
                                    Payment Done.
                                    </span>    
                                @else
                                    <a href="{{ route('admin.showPaymentForm', ['appointmentID' => $appointment->appointmentID]) }}" 
                                    class="text-indigo-600 hover:text-indigo-900">
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
