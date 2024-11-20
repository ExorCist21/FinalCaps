<title>Subscribe a Plan</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight text-center">
            {{ __('Subscribe to a Plan') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto rounded-lg p-6">
        <!-- Page Title -->
        <h1 class="text-xl font-semibold text-gray-800 mb-6">Choose Your Service Plan</h1>

        <form action="{{ route('subscriptions.store') }}" method="POST" class="space-y-6">
            @csrf
            <!-- 3-Column Layout -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Service Name -->
                <div>
                    <label for="service_name" class="block text-sm font-medium text-gray-700">Service Name</label>
                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ request('service_name') }}</p>
                    <input type="hidden" name="service_name" value="{{ request('service_name') }}" readonly 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <p class="mt-1 text-lg font-semibold text-gray-800">₱{{ request('price') }}</p>
                    <input type="hidden" name="price" value="{{ request('price') }}">
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Duration</label>
                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ request('duration') }} Month(s)</p>
                    <input type="hidden" name="duration" value="{{ request('duration') }}">
                </div>
            </div>

            <!-- Payment Method -->
            <fieldset>
                <legend class="block text-sm font-medium text-gray-700 mb-2">Payment Method</legend>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <input type="radio" id="gcash" name="payment_method" value="gcash" required>
                        <label for="gcash" class="text-gray-700">Gcash</label>
                    </div>
                    <div>
                        <input type="radio" id="maya" name="payment_method" value="maya">
                        <label for="maya" class="text-gray-700">Maya</label>
                    </div>
                    <div>
                        <input type="radio" id="credit_card" name="payment_method" value="credit_card">
                        <label for="credit_card" class="text-gray-700">Credit Card</label>
                    </div>
                    <div>
                        <input type="radio" id="paypal" name="payment_method" value="paypal">
                        <label for="paypal" class="text-gray-700">Paypal</label>
                    </div>
                </div>
            </fieldset>

            <!-- QR Code Section -->
            <div id="qr_code_section" class="hidden text-center">
                <p class="block text-sm font-medium text-gray-700">Scan the QR code to complete your payment</p>
                <img id="qr_image" src="" alt="Payment QR Code" class="w-1/2 mx-auto mt-4 rounded-md">
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" 
                        class="mt-5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-6 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Proceed to Payment
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const qrImage = document.getElementById('qr_image');
            const qrCodeSection = document.getElementById('qr_code_section');

            paymentMethods.forEach(method => {
                method.addEventListener('change', function () {
                    let qrCodeUrl = '';

                    switch (this.value) {
                        case 'gcash':
                            qrCodeUrl = '/images/gcash_qr.jpg'; // Replace with actual Gcash QR code path
                            break;
                        case 'maya':
                            qrCodeUrl = '/images/maya_qr.png';  // Replace with actual Maya QR code path
                            break;
                        case 'credit_card':
                            qrCodeUrl = '/images/credit_card_qr.png';
                            break;
                        case 'paypal':
                            qrCodeUrl = '/images/paypal_qr.png';
                            break;
                        default:
                            qrCodeSection.classList.add('hidden');
                            return;
                    }

                    qrImage.src = qrCodeUrl;
                    qrCodeSection.classList.remove('hidden');
                });
            });
        });
    </script>
</x-app-layout>
