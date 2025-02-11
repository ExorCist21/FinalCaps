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
                <div class="bg-green-500 text-white p-3 rounded-lg mb-4 shadow-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-500 text-white p-3 rounded-lg mb-4 shadow-lg">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        @if ($subscriptions->isEmpty())
            <div class="bg-gray-100 text-center p-6 rounded-lg shadow-lg">
                <p class="text-lg text-gray-700">No pending sessions for approval.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="min-w-full table-auto border-collapse text-sm">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left font-medium">User</th>
                            <th class="py-3 px-4 text-left font-medium">Service Name</th>
                            <th class="py-3 px-4 text-left font-medium">Amount</th>
                            <th class="py-3 px-4 text-left font-medium">Payment Method</th>
                            <th class="py-3 px-4 text-left font-medium">Status</th>
                            <th class="py-3 px-4 text-center font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 border-t">
                                <td class="py-3 px-4">{{ $subscription->patient->name }}</td>
                                <td class="py-3 px-4">{{ $subscription->service_name }}</td>
                                @if ($subscription->payment)
                                    <td class="py-3 px-4">₱{{ number_format($subscription->payment->amount, 2) }}</td>
                                    <td class="py-3 px-4 capitalize">{{ ucfirst($subscription->payment->payment_method) }}</td>
                                @else
                                    <td colspan="2" class="py-3 px-4 text-gray-500">No payment record</td>
                                @endif
                                <td class="py-3 px-4 capitalize">{{ $subscription->status }}</td>
                                <td class="py-3 px-4 flex items-center justify-center space-x-2">
                                    <form action="{{ route('admin.subscriptions.approve', $subscription->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="subscription_id" value="{{ $subscription->patient->id }}">
                                        <button type="submit" class="bg-green-500 text-white py-1 px-3 rounded-lg hover:bg-green-600 transition duration-200">Approve</button>
                                        <button type="button" class="bg-blue-500 text-white py-1 px-3 rounded-lg hover:bg-blue-600 transition duration-200"
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
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg">
            <button class="text-gray-500 hover:text-gray-900 float-right text-2xl" onclick="closeModal()">×</button>
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Payment Proof</h3>
            <div class="text-center">
                <img id="proofImage" src="" alt="Proof of Payment" class="w-full h-48 object-cover mb-4 rounded-md shadow-lg cursor-pointer" onclick="viewFullImage()">
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

        function viewFullImage() {
            const imageSrc = document.getElementById('proofImage').src;
            const imageModal = window.open(imageSrc, '_blank', 'width=800,height=600');
            imageModal.focus();
        }

        window.onclick = function (event) {
            const modal = document.getElementById('proofModal');
            if (event.target === modal) {
                closeModal();
            }
        };

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
