<title>Therapist Payments</title>
<x-app-layout>
    <div class="container mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Therapist Payments to Admin</h2>

        <table class="min-w-full bg-white shadow-md rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4">Therapist</th>
                    <th class="py-2 px-4">Amount</th>
                    <th class="py-2 px-4">Method</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Proof</th>
                    <th class="py-2 px-4">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr class="border-b">
                        <td class="py-2 px-4 text-center">{{ $payment->appointment->therapist->name }}</td>
                        <td class="py-2 px-4 text-center">₱{{ number_format($payment->amount, 2) }}</td>
                        <td class="py-2 px-4 text-center">{{ ucfirst($payment->payment_method) }}</td>
                        <td class="py-2 px-4 text-center">
                            @if($payment->status === 'pending')
                                <span class="text-yellow-600 font-semibold">Pending</span>
                            @else
                                <span class="text-green-600 font-semibold">Confirmed</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 text-center">
                            <a href="{{ asset('storage/' . $payment->proof) }}" target="_blank" class="text-blue-500 underline">View Proof</a>
                        </td>
                        <td class="py-2 px-4 text-center">
                            @if($payment->status === 'pending')
                                <form action="{{ route('admin.confirmTherapistPayment', $payment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded">
                                        Confirm
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500">Confirmed</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
