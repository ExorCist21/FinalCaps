<title>Submit Payment Proof</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Submit Payment Proof') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto border rounded-lg p-6">
        <!-- Page Title -->
        <h1 class="text-xl font-semibold text-gray-800 mb-6">Complete Your Payment</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 mb-6 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-6 rounded-lg shadow">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="subscription_id" value="{{ $subscription_id }}">

            <!-- Payment Method -->
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <input type="text" name="payment_method" value="{{ $payment_method }}" readonly 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount to Pay</label>
                <input type="text" name="amount" value="{{ $price }}" readonly 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Upload Proof -->
            <div>
                <label for="proof" class="block text-sm font-medium text-gray-700">Upload Payment Proof</label>
                <input type="file" name="proof" required 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit Payment Proof
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
