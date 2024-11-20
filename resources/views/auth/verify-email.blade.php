<x-app-layout>
    <div class="max-w-lg mx-auto p-10 bg-gray-50 rounded-md border">
        <h2 class="text-2xl font-semibold text-center text-gray-800 200 mb-4">
            Verify Your Email Address
        </h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            Thanks for signing up! We're thrilled to have you on board. Before you can start connecting with MentalWell, please verify your email by clicking on the link we've sent to your inbox. If you didn’t receive the email, don’t worry – we can send you another one.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-center text-sm font-medium text-green-600">
                A new verification link has been sent to your email address. Please check your inbox!
            </div>
        @endif

        <div class="text-center">
            <form method="POST" action="{{ route('verification.send') }}" class="inline-block">
                @csrf
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Resend Verification Email
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            Having trouble? Contact our <a href="#" class="text-indigo-600 hover:underline">support team</a>. We're here to help.
        </p>
    </div>
</x-app-layout>
