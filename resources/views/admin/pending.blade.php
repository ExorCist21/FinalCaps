<title>Pending Subscriptions</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Pending Subscriptions') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        <div class="mb-6">
            @if (session('success'))
                <div class="bg-green-500 text-white p-3 rounded mb-4 shadow">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-500 text-white p-3 rounded mb-4 shadow">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        @if ($subscriptions->isEmpty())
            <div class="bg-gray-100 text-center p-6 rounded-lg shadow">
                <p class="text-lg text-gray-700">No pending sessions for approval.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 shadow rounded-lg">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">User</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Service Name</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Amount</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Payment Method</th>
                            <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Status</th>
                            <th class="py-3 px-4 text-center text-sm font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $subscription)
                            <tr class="hover:bg-gray-100 border-t">
                                <td class="py-3 px-4">{{ $subscription->patient->name }}</td>
                                <td class="py-3 px-4">{{ $subscription->service_name }}</td>
                                @if ($subscription->payment)
                                    <td class="py-3 px-4">₱{{ $subscription->payment->amount }}</td>
                                    <td class="py-3 px-4 capitalize">{{ $subscription->payment->payment_method }}</td>
                                @else
                                    <td colspan="2" class="py-3 px-4 text-gray-500">No payment record</td>
                                @endif
                                <td class="py-3 px-4 capitalize">{{ $subscription->status }}</td>
                                <td class="py-3 px-4 flex items-center justify-center space-x-2">
                                    <form action="{{ route('admin.subscriptions.approve', $subscription->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="subscription_id" value="{{ $subscription->patient->id }}">
                                        <button type="submit" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600 transition">Approve</button>
                                        <button type="button" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600 transition"
                                            onclick="showModal('{{ $subscription->payment->proof ?? '' }}', '{{ $subscription->payment->amount ?? 'N/A' }}', '{{ ucfirst($subscription->payment->payment_method ?? 'N/A') }}')">
                                            View
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div id="proofModal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <button class="text-gray-500 hover:text-gray-900 float-right" onclick="closeModal()">×</button>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Payment Proof</h3>
            <div class="text-center">
                <img id="proofImage" src="" alt="Proof of Payment" class="w-full h-48 object-cover mb-4 rounded-md shadow">
                <p class="text-sm"><strong>Amount:</strong> ₱<span id="amount"></span></p>
                <p class="text-sm"><strong>Payment Method:</strong> <span id="paymentMethod"></span></p>
                <p class="text-sm"><strong>Status:</strong> <span id="status">Pending</span></p>
            </div>
        </div>
    </div>

    <script>
        function showModal(proof, amount, paymentMethod) {
            document.getElementById('proofImage').src = proof || '/images/default-proof.png';
            document.getElementById('amount').innerText = amount;
            document.getElementById('paymentMethod').innerText = paymentMethod;
            document.getElementById('proofModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('proofModal').classList.add('hidden');
        }

        window.onclick = function (event) {
            const modal = document.getElementById('proofModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</x-app-layout>