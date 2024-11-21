<title>Submit Payment Proof</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Submit Payment Proof</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-2 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-4">
            @csrf
            <input type="hidden" name="subscription_id" value="{{ $subscription_id }}">

            <div class="mb-4">
                <label for="payment_method" class="block text-sm font-medium">Payment Method:</label>
                <input type="text" name="payment_method" value="{{ $payment_method }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium">Amount to Pay:</label>
                <input type="text" name="amount" value="{{ $price }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="proof" class="block text-sm font-medium">Upload Payment Proof:</label>
                <input type="file" name="proof" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Submit Payment Proof</button>
        </form>

    </div>
</x-app-layout>
