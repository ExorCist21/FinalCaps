<title>Provide Feedback</title>
<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-md shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Provide Feedback</h2>
        
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 mb-4 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('feedback.submit') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="message" class="block text-gray-700 font-semibold">Your Feedback</label>
                <textarea name="message" id="message" rows="4" class="w-full border border-gray-300 p-2 rounded-md" required></textarea>
            </div>

            <div class="mb-6">
                    <label for="rating" class="block text-sm font-medium text-gray-700">Rate Our System</label>
                    <select 
                        name="rating"   
                        id="rating" 
                        class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                        required>
                        <option value="" disabled selected>Choose a rating</option>
                        <option value="1">1 - Very Poor</option>
                        <option value="2">2 - Poor</option>
                        <option value="3">3 - Average</option>
                        <option value="4">4 - Good</option>
                        <option value="5">5 - Excellent</option>
                    </select>
                </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Submit Feedback
            </button>
        </form>
    </div>

    <script>
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
