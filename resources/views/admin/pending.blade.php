<title>Pending Subscriotions</title>
<x-app-layout>
    <h1 class="text-2xl font-bold mb-4">Pending Subscriptions</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if($subscriptions->isEmpty())
        <p>No pending subscriptions.</p>
    @else
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">User</th>
                    <th class="py-2 px-4 border-b">Service Name</th>
                    <th class="py-2 px-4 border-b">Amount</th>
                    <th class="py-2 px-4 border-b">Payment Method</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $subscription)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b">{{ $subscription->patient->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $subscription->service_name }}</td>

                        <!-- Check if the payment exists -->
                        @if($subscription->payment)
                            <td class="py-2 px-4 border-b">{{ $subscription->payment->amount }}</td>
                            <td class="py-2 px-4 border-b">{{ ucfirst($subscription->payment->payment_method) }}</td>
                        @else
                            <td colspan="2" class="py-2 px-4 border-b">No payment record</td>
                        @endif

                        <td class="py-2 px-4 border-b">{{ $subscription->status }}</td>
                        <td class="py-2 px-4 border-b">
                            <form action="{{ route('admin.subscriptions.approve', $subscription->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white py-1 px-3 rounded">Approve</button>
                            </form>
                            <!-- View Proof Button -->
                            <button type="button" class="bg-blue-500 text-white py-1 px-3 rounded ml-2" 
                                onclick="showModal('{{ $subscription->payment->proof ?? '' }}', '{{ $subscription->payment->amount ?? 'N/A' }}', '{{ ucfirst($subscription->payment->payment_method ?? 'N/A') }}')">
                                View
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Modal -->
    <div id="proofModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-5 max-w-lg w-full">
            <span class="close text-gray-500 cursor-pointer" onclick="closeModal()">&times;</span>
            <div id="modal-body" class="mt-4">
                <img id="proofImage" src="" alt="Proof of Payment" class="img-fluid mb-2" />
                <p><strong>Amount:</strong> <span id="amount"></span></p>
                <p><strong>Payment Method:</strong> <span id="paymentMethod"></span></p>
                <p><strong>Status:</strong> <span id="status"></span></p>
            </div>
        </div>
    </div>

    <script>
        // Function to show modal
        function showModal(proof, amount, paymentMethod) {
            document.getElementById('proofImage').src = proof || 'default-image.png'; // Default image if no proof
            document.getElementById('amount').innerText = amount;
            document.getElementById('paymentMethod').innerText = paymentMethod;
            document.getElementById('status').innerText = 'Pending'; 
            document.getElementById('proofModal').classList.remove('hidden');
        }

        // Function to close modal
        function closeModal() {
            document.getElementById('proofModal').classList.add('hidden');
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('proofModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</x-app-layout>