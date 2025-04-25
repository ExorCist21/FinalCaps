<x-app-layout>
    <div class="h-screen flex bg-gray-100 mx-auto max-w-7xl sm:px-6 lg:px-8" style="height: 90vh;">
        <!-- Sidebar -->
        <div class="w-1/4 bg-white border-r border-gray-200">
            <div class="p-4 space-y-4">
            <div onclick="setSelectedUser({{ $contactUser->toJson() }})"
                class="flex items-center p-2 hover:bg-blue-500 hover:text-white rounded cursor-pointer"
                id="user-{{ $contactUser->id }}">
                <div class="w-12 h-12 bg-blue-200 rounded-full"></div>
                <div class="ml-4">
                    <div class="p-4 border-b border-gray-300">
                        <h2 class="text-lg font-semibold">Appointment with: {{ $contactUser->name }}</h2>
                        <p>Date and Time: {{ $appointment->datetime }}</p>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Contact Area -->
        <div class="flex flex-col w-3/4">
            <div id="selectPrompt" class="h-full flex justify-center items-center text-gray-800 font-bold">Select Contact</div>

            <div id="callArea" style="display:none;">
                <div class="p-4 border-b border-gray-200 flex items-center">
                    <div class="w-12 h-12 bg-blue-200 rounded-full"></div>
                    <div class="ml-4">
                        <div class="font-bold" id="selectedUserName"></div>
                        <button id="callBtn" onclick="callUser()" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Call</button>
                        <button id="endCallBtn" onclick="endCall()" style="display:none;" class="ml-4 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">End Call</button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 relative">
                    <video id="remoteVideo" autoplay playsinline muted class="border-2 border-gray-800 w-full" style="display:none;"></video>
                    <video id="localVideo" autoplay playsinline muted class="m-0 border-2 border-gray-800 absolute top-6 right-6 w-4/12" style="margin: 0; display:none;"></video>
                    <div id="noCallNotice" class="h-full flex justify-center items-center text-gray-800 font-bold">No Ongoing Call.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Accept/Reject Call -->
    <div id="callModal" class="fixed inset-0 flex justify-center items-center bg-gray-700 bg-opacity-50 z-50" style="display:none;">
        <div class="bg-white p-8 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold mb-4">Incoming Call from {{ $contactUser->name }}</h3>
            <div class="flex justify-between">
                <button onclick="rejectCall()" class="px-4 py-2 bg-red-500 text-white rounded-lg">Reject</button>
                <button onclick="acceptCall()" class="px-4 py-2 bg-green-500 text-white rounded-lg">Accept</button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/peerjs@1.3.1/dist/peerjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/peerjs@1.4.7/dist/peerjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        const authUserId = {{ Auth::user()->id }};
        let selectedUser = null;
        let peer = new Peer();
        let peerCall = null;
        let localStream = null;

        function setSelectedUser(user) {
            selectedUser = user;
            document.getElementById('selectedUserName').textContent = user.name;
            document.getElementById('selectPrompt').style.display = 'none';
            document.getElementById('callArea').style.display = 'block';
        }

        function displayLocalVideo() {
            navigator.mediaDevices.getUserMedia({ video: true, audio: true }).then(stream => {
                document.getElementById('localVideo').srcObject = stream;
                document.getElementById('localVideo').style.display = 'block';
                localStream = stream;
            }).catch(console.error);
        }

        function callUser() {
            axios.post(`/video-call/request/${selectedUser.id}`, { peerId: peer.id });
            displayLocalVideo(); // Show caller's local video
            document.getElementById('callBtn').style.display = 'none';
            document.getElementById('endCallBtn').style.display = 'inline-block';
        }

        function endCall() {
            if (peerCall) peerCall.close();
            if (localStream) localStream.getTracks().forEach(track => track.stop());
            document.getElementById('remoteVideo').srcObject = null;
            document.getElementById('localVideo').srcObject = null;
            document.getElementById('localVideo').style.display = 'none';
            document.getElementById('remoteVideo').style.display = 'none';
            document.getElementById('callBtn').style.display = 'inline-block';
            document.getElementById('endCallBtn').style.display = 'none';
        }

        function acceptCall() {
            document.getElementById('callModal').style.display = 'none'; // Close the modal
            axios.post(`/video-call/request/status/${selectedUser.id}`, { peerId: peer.id });

            peer.on('call', call => {
                peerCall = call;
                if (selectedUser.peerId === call.peer) {
                    navigator.mediaDevices.getUserMedia({ video: true, audio: true }).then(stream => {
                        call.answer(stream); // Answer the call
                        document.getElementById('localVideo').srcObject = stream;
                        document.getElementById('localVideo').style.display = 'block';

                        call.on('stream', remoteStream => {
                            document.getElementById('remoteVideo').srcObject = remoteStream; // Show remote video
                            document.getElementById('remoteVideo').style.display = 'block';
                            document.getElementById('noCallNotice').style.display = 'none';
                        });

                        call.on('close', () => endCall());
                    });
                }
            });
        }

        function rejectCall() {
            document.getElementById('callModal').style.display = 'none'; // Close the modal
            // Optionally, notify the caller that the call was rejected
            axios.post(`/video-call/reject/${selectedUser.id}`);
        }

        function createConnection(e) {
            let receiverId = e.user.peerId;
            navigator.mediaDevices.getUserMedia({ video: true, audio: true }).then(stream => {
                const call = peer.call(receiverId, stream);
                peerCall = call;
                call.on('stream', remoteStream => {
                    document.getElementById('remoteVideo').srcObject = remoteStream;
                    document.getElementById('remoteVideo').style.display = 'block';
                    document.getElementById('noCallNotice').style.display = 'none';
                });
                call.on('close', () => endCall());
            });
        }

        function connectWebSocket() {
            window.Echo.private(`video-call.${authUserId}`)
                .listen('RequestVideoCall', e => {
                    selectedUser = e.user.fromUser; // The user who called
                    document.getElementById('callModal').style.display = 'flex'; // Show the accept/reject modal
                    displayLocalVideo(); // Show caller's local video
                })
                .listen('RequestVideoCallStatus', e => {
                    createConnection(e);
                });
        }

        window.onload = connectWebSocket;
    </script>
</x-app-layout>
