<!-- resources/views/meeting.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Page</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">
            @if(Auth::user()->role == 'therapist')
                Create a Meeting
            @else
                Meeting
            @endif
        </h1>

        @foreach($appointments as $appointment)
            <div class="mb-6 p-4 border rounded-lg bg-gray-50">
                <p class="text-gray-700 mb-2">
                    @if(Auth::user()->role == 'therapist')
                        Create a meeting with <span class="font-semibold">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</span>
                    @else
                        Meeting with <span class="font-semibold">{{ $appointment->therapist->first_name }} {{ $appointment->therapist->last_name }}</span>
                    @endif
                </p>

                <p class="text-gray-600 text-sm">
                    Scheduled at: {{ \Carbon\Carbon::parse($appointment->datetime)->format('F j, Y - g:i A') }}
                </p>
            </div>
        @endforeach

        <div class="mb-4">
            <label for="linkUrl" class="block text-gray-700 mb-2">Meeting Code</label>
            <input 
                type="text"
                id="linkUrl"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" 
                placeholder="Enter meeting code or link"
            >
        </div>

        <div class="flex justify-between space-x-4">
            <button
                onclick="joinMeeting()"
                id="join-btn1"
                class="w-1/2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg"
            >
                Join Meeting
            </button>

            @if(Auth::user()->role == 'therapist')
                <a href="{{ route('createMeeting') }}" class="w-1/2">
                    <button
                        id="join-btn2"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg"
                    >
                        Create Meeting
                    </button>
                </a>
            @endif
        </div>
    </div>

</body>

<script>
    function joinMeeting() {
        var link = $('#linkUrl').val();
        if (link.trim() == '' || link.length < 1) {
            alert('Please enter a valid link.');
            return;
        } else {
            window.location.href = link;
        }
    }
</script>
</html>
