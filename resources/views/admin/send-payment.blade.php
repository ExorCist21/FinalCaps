<title>Send Payment</title>
<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800">Send Payment to Therapist</h2>
        <p class="text-gray-600 mb-4">For appointment ID: {{ $appointment->appointmentID }}</p>

        <!-- Show therapist and payment info -->
        <div class="bg-white p-6 rounded-md shadow-md mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Therapist: {{ $appointment->therapist->name }}</h3>
            <p class="text-sm text-gray-600">GCash Number: {{ $appointment->therapist->therapistInformation->gcash_number ?? 'N/A' }}</p>
            <p class="text-sm text-gray-600">Session Status: {{ $appointment->progress->firstWhere('status', 'Completed')->status ?? 'No completed progress' }} </p>
        </div>

        @if(session('error'))
            <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Payment form -->
        <form action="{{ route('admin.sendPayment', ['appointmentID' => $appointment->appointmentID]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" name="amount" id="amount" class="mt-1 block w-full text-sm border-gray-300 rounded-md" required value="{{ old('amount') }}">
                @error('amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <input type="text" name="payment_method" id="payment_method" class="mt-1 block w-full text-sm border-gray-300 rounded-md" required value="{{ old('payment_method') }}">
                @error('payment_method')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="payment_proof" class="block text-sm font-medium text-gray-700">Upload Payment Proof</label>
                <input type="file" name="payment_proof" id="payment_proof" class="mt-1 block w-full text-sm border-gray-300 rounded-md" required>
                @error('payment_proof')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between items-center">
                <button type="button" class="bg-gray-200 text-gray-900 px-4 py-2 rounded-md hover:bg-gray-300">Cancel</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Send Payment</button>
            </div>
        </form>
    </div>
</x-app-layout>
