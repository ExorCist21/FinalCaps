<title>Payments</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <!-- Page Header -->
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-3xl font-semibold text-gray-800">Payment Management</h2>
            <p class="text-gray-600">Manage payments for completed sessions.</p>
        </div>


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
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow-md 
                                            hover:bg-indigo-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.1 0 2-.9 2-2V4m-2 4c-1.1 0-2-.9-2-2V4m-2 8h8m-8 4h8m-8 4h8M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
