<title>Subscribe a Plan</title>
<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Purchase Session Plan</h1>

        <form action="{{ route('subscriptions.store') }}" method="POST" class="bg-white shadow rounded-lg p-4">
            @csrf
            <!-- Service Name -->
            <div class="mb-4">
                <label for="service_name" class="block text-sm font-medium">Service Name:</label>
                <input type="text" name="service_name" value="{{ request('service_name') }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>

            <!-- Hidden Price Field -->
            <div class="mb-4">
                <input type="hidden" name="price" value="{{ request('price') }}">
                <p class="text-sm font-medium">Price: ₱{{ request('price') }}</p>
            </div>

            <!-- Duration -->
            <div class="mb-4">
                <input type="hidden" name="duration" value="{{ request('duration') }}">
                <p class="text-sm font-medium">Session: +{{ request('duration') }} Sessions</p>
            </div>

            <!-- Payment Method -->
            <fieldset class="mb-4">
                <legend class="block text-sm font-medium mb-2">Payment Method:</legend>
                <div>
                    <input type="radio" id="gcash" name="payment_method" value="gcash" required>
                    <label for="gcash">Gcash</label>
                </div>
                <div>
                    <input type="radio" id="maya" name="payment_method" value="maya">
                    <label for="maya">Maya</label>
                </div>
                <div>
                    <input type="radio" id="credit_card" name="payment_method" value="credit_card">
                    <label for="credit_card">Credit Card</label>
                </div>
                <div>
                    <input type="radio" id="paypal" name="payment_method" value="paypal">
                    <label for="paypal">Paypal</label>
                </div>
            </fieldset>

            <!-- Display QR Code Based on Selected Payment Method -->
            <div id="qr_code_section" class="hidden mb-4">
                <p class="block text-sm font-medium">Scan the QR code to complete your payment:</p>
                <img id="qr_image" src="" alt="Payment QR Code" class="w-48 h-48 mx-auto">
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Proceed to Payment</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const qrImage = document.getElementById('qr_image');
            const qrCodeSection = document.getElementById('qr_code_section');

            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    let qrCodeUrl = '';

                    switch (this.value) {
                        case 'gcash':
                            qrCodeUrl = '/images/gcash_qr.jpg'; // Update to actual Gcash QR code path
                            break;
                        case 'maya':
                            qrCodeUrl = '/images/maya_qr.png';  // Update to actual Maya QR code path
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
