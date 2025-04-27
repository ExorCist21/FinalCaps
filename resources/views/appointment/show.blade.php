<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Video Call</title>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
</head>
<body>

<h2>Appointment Details</h2>
<p>Patient Name: <span id="userName">{{ $patientName }}</span></p>
<p>Therapist Name: <span id="userName">{{ $therapistName }}</span></p>

<div id="video-container" style="display:none;">
    <div id="local-player" style="width: 400px; height: 300px; background-color: black;"></div>
    <div id="remote-player" style="width: 400px; height: 300px; background-color: black;"></div>
</div>

<button id="callBtn">Call</button>
<button id="acceptBtn" style="display:none;">Accept</button>
<button id="rejectBtn" style="display:none;">Reject</button>
<button id="endCallBtn" style="display:none;">End Call</button>

<script>
    let client;
    let localStream;
    let remoteStream;
    let channelName = "appointment_{{ $appointmentID }}"; // from server
    const uid = Number("{{ Auth::id() }}");

    document.getElementById('callBtn').onclick = startCall;
    document.getElementById('acceptBtn').onclick = acceptCall;
    document.getElementById('rejectBtn').onclick = rejectCall;
    document.getElementById('endCallBtn').onclick = endCall;

    async function startCall() {
        const tokenData = await fetch(`/video-call/{{ $appointmentID }}/agora-token`).then(res => res.json());

        client = AgoraRTC.createClient({ mode: "rtc", codec: "vp8" });

        await client.join(tokenData.appId, tokenData.channelName, tokenData.token, uid);

        localStream = await AgoraRTC.createMicrophoneAndCameraTracks();

        document.getElementById('video-container').style.display = 'block';

        const localPlayerContainer = document.getElementById('local-player');
        localPlayerContainer.innerHTML = "";
        localStream[1].play('local-player');

        await client.publish([localStream[0], localStream[1]]);

        client.on("user-published", async (user, mediaType) => {
            await client.subscribe(user, mediaType);

            if (mediaType === "video") {
                const remotePlayerContainer = document.getElementById('remote-player');
                remotePlayerContainer.innerHTML = "";
                user.videoTrack.play('remote-player');
            }

            if (mediaType === "audio") {
                user.audioTrack.play();
            }
        });

        document.getElementById('callBtn').style.display = 'none';
        document.getElementById('endCallBtn').style.display = 'inline';
    }

    async function acceptCall() {
        startCall();
        document.getElementById('acceptBtn').style.display = 'none';
        document.getElementById('rejectBtn').style.display = 'none';
    }

    function rejectCall() {
        alert("You rejected the call.");
        document.getElementById('acceptBtn').style.display = 'none';
        document.getElementById('rejectBtn').style.display = 'none';
    }

    function endCall() {
        if (localStream) {
            localStream.close();
            localStream.stop();
        }
        if (remoteStream) {
            remoteStream.stop();
        }
        client && client.leave(() => {
            console.log("Left the channel");
        }, (err) => {
            console.log("Leave channel failed", err);
        });

        document.getElementById('endCallBtn').style.display = 'none';
        document.getElementById('callBtn').style.display = 'inline';
        document.getElementById('video-container').style.display = 'none';
    }
</script>

</body>
</html>