<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Video Stream</title>
</head>
<body class="bg-gray-50 font-sans flex items-center justify-center min-h-screen">
    <!------------@if(!session()->has('meeting'))
            <input type="text" id="user_name" value="">
        @endif ---------->    
    <!-- Main Container -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <!-- User Name Section -->
        @if(!session()->has('meeting'))
        <div class="mb-6">
            <label for="user_name" class="block text-lg font-semibold text-gray-700">Enter your name:</label>
            <input type="text" id="user_name" name="user_name" value="{{ Auth::user()->name }}" placeholder="Enter your name" class="form-input mt-2 p-3 w-full border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>
        @endif

        <!-- URL and Buttons Section -->
        <div class="mb-6">
            <input type="text" id="linkUrl" value="{{url('joinMeeting')}}/{{$meeting->url}}" class="w-full p-3 border rounded-lg shadow-sm text-gray-700" readonly />
            <div class="flex justify-between mt-4">
                <button id="join-btn2" class="bg-indigo-600 text-white py-2 px-6 rounded-lg shadow-lg hover:bg-indigo-700 transition duration-300">Join Stream</button>
                <button id="join-btns" onclick="copyLink()" class="bg-gray-300 text-gray-700 py-2 px-6 rounded-lg hover:bg-gray-400 transition duration-300">Copy Link</button>
            </div>
        </div>

        <!-- Video Stream and Controls -->
        <div class="mb-6">
            <div id="local-streams" class="border border-gray-300 rounded-lg p-4 mb-4">
                <!-- Local video will be here -->
            </div>
            <div id="remote-streams" class="border border-gray-300 rounded-lg p-4 mb-4">
                <!-- Remote videos will be here -->
            </div>
            <div id="stream-controls" class="flex space-x-4 justify-center hidden">
                <button id="leave-btn" class="bg-red-600 text-white py-2 px-6 rounded-lg hover:bg-red-700 transition duration-300">Leave Stream</button>
                <button id="mic-btn" class="bg-green-600 text-white py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">Mic On</button>
                <button id="camera-btn" class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-300">Camera On</button>
            </div>
        </div>

        <!-- Hidden Inputs -->
        <input id="appid" type="hidden" value="{{$meeting->app_id}}" readonly>
        <input id="token" type="hidden" value="{{$meeting->token}}" readonly>
        <input id="channel" type="hidden" value="{{$meeting->channel}}" readonly>
        <input id="urlId" type="hidden" value="{{$meeting->url}}" readonly>
        <input id="event" type="hidden" value="{{$event}}" readonly>
        <input id="timer" type="hidden" value="0">
        <input id="user_meeting" type="hidden" value="0">
        <input id="user_permission" type="hidden" value="0">

    </div>

    <script src="{{ asset('video/main.js') }}"></script>
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

    <script>
        var notificationChannel = $('#channel').val();
        var notificationEvent = $('#event').val();
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('0c02da155625e253c897', {
        cluster: 'ap2'
        });

        var channel = pusher.subscribe(notificationChannel);
        channel.bind(notificationEvent, function(data) {
        @if(session()->has('meeting'))
            if(confirm(data.title)) {
                meetingApprove(data.random_user, 2);
            } else {
                meetingApprove(data.random_user, 3);
            }
        @else
            if(data.status == 0) {
                $('#join-btn2').click();
                document.getElementById('stream-controls').style.display = "flex";
                $('#timer').val(1);
            } else if(data.status == 3){
                alert('You have been denied.'); 
            }
        @endif
        });
    </script>

    <script>
        function copyLink() {
            var urlPage = window.location.href;
            var temp = $("<input>");
            $("body").append(temp);
            temp.val(urlPage).select();
            document.execCommand("copy");
            temp.remove();
            $('#join-btns').text('URL COPIED');
        }

        function saveUserName(name) {
            var url = "{{url('saveUserName')}}"
            var random = "{{session()->get('random_user')}}";
            var urlId = $('#urlId').val();
            $.ajax({
                url : url,
                headers:{
                    'X-CSRF-TOKEN':'{{csrf_token()}}'
                },
                data:{
                    'url': urlId,
                    'name': name,
                    'random': random
                },
                type: 'post',
                success:function (result) {
                    
                }
            })
        }

        function meetingApprove(random_user, type) {
            var url = "{{url('meetingApprove')}}"
            var urlId = $('#urlId').val();
            $.ajax({
                url : url,
                headers:{
                    'X-CSRF-TOKEN':'{{csrf_token()}}'
                },
                data:{
                    'url': urlId,
                    'type': type,
                    'random': random_user
                },
                type: 'post',
                success:function (result) {
                    
                }
            })
        }

        @if(!session()->has('meeting'))
            window.setInterval(function() {
                callRecordTime();
            }, 10000)
        @else
        @endif

        function callRecordTime() {
            var timer = $('#timer').val();
            if(timer == 1) {
                var url = "{{url('callRecordTime')}}"
                var random = "{{session()->get('random_user')}}";
                var urlId = $('#urlId').val();
                $.ajax({
                    url : url,
                    headers:{
                        'X-CSRF-TOKEN':'{{csrf_token()}}'
                    },
                    data:{
                        'url': urlId,
                        'random': random
                    },
                    type: 'post',
                    success:function (result) {
                        
                    }
                })
            }
        }

    </script>
</body>
</html>
