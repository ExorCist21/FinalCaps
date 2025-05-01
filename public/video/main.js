const APP_ID = $('#appid').val();
//const TOKEN = $('#token').val();
const TOKEN = '007eJxTYHh3it14bryKhQRjhDzX+r2unbnlvQeFHSv9f6lMzU2x+6vAYG5uaGpmnGZgmWRqYGKckppobJ5ibmlpZGKQapxoamz51kMgoyGQkSHFO4eRkQECQXxOhsT0/KJEE0MTYwYGANCuHMc=';
const CHANNEL = $('#channel').val();

const client = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8'})

let localTracks = []
let remoteUsers = {}

let joinAndDisplayLocalStream = async () => {
    client.on('user-published', handleUserJoined)

    client.on('user-left', handleUserLeft)

    let UID = await client.join(APP_ID, CHANNEL, TOKEN, null)

    localTracks = await AgoraRTC.createMicrophoneAndCameraTracks()

    let player = `<div id="user-container-${UID}" class="p-2">
                <div id="user-${UID}" class="w-full h-64 bg-black rounded-lg overflow-hidden"></div>
              </div>`

    document.getElementById('local-streams').insertAdjacentHTML('beforeend', player)
    

    localTracks[1].play(`user-${UID}`)

    await client.publish([localTracks[0], localTracks[1]])

    document.getElementById('stream-controls').style.display = 'flex'; 
    document.getElementById('join-btn2').style.display = 'none';
}

let joinStream = async () => {
    try {
        await joinAndDisplayLocalStream()
        $('#timer').val(1);
        RecordTime();
    }
    catch (err) {
        return;
    } 
}

let handleUserJoined = async (user, mediaType) => {
    remoteUsers[user.uid] = user
    await client.subscribe(user, mediaType)

    if (mediaType === 'video') {
        let player = document.getElementById(`user-container-${user.uid}`)
        if (player == null) {
            player = `<div id="user-container-${user.uid}" class="p-2">
                        <div id="user-${user.uid}" class="w-full h-64 bg-black rounded-lg overflow-hidden"></div>
                      </div>`;
            document.getElementById('remote-streams').insertAdjacentHTML('beforeend', player)
           
        }

        user.videoTrack.play(`user-${user.uid}`)

    }

    if (mediaType === 'audio') {
        user.audioTrack.play()
    }

}

let handleUserLeft = async (user) => {
    delete remoteUsers[user.uid]
    let player = document.getElementById(`user-container-${user.uid}`)
    if (player) {
        player.remove()
    }
}

let leaveAndRemoveLocalStream = async () => {
    for (let i = 0; localTracks.length > i; i++) {
        localTracks[i].stop()
        localTracks[i].close()
    }

    await client.leave()
    document.getElementById('join-btn2').style.display = 'block';
    document.getElementById('stream-controls').style.display = 'none';
    document.getElementById('remote-streams').innerHTML = '';
    $('#timer').val(0);
    //document.getElementById('dataTable').style.display = 'block';

}

let toggleMic = async (e) => {
    if (localTracks[0].muted) {
        await localTracks[0].setMuted(false)
        e.target.innerText = 'Mic On'
        e.target.style.backgroundColor = 'cadetblue'
    } else {
        await localTracks[0].setMuted(true)
        e.target.innerText = 'Mic Off'
        e.target.style.backgroundColor = '#EE4828'
    }
}

let toggleCamera = async (e) => {
    if (localTracks[1].muted) {
        await localTracks[1].setMuted(false)
        e.target.innerText = 'Camera On'
        e.target.style.backgroundColor = 'cadetblue'
    } else {
        await localTracks[1].setMuted(true)
        e.target.innerText = 'Camera Off'
        e.target.style.backgroundColor = '#EE4828'
    }
}

let togglerecording = async (e) => {
    if ($('#rec_user').val() == 0) {
        await (StartRecording());
        e.target.innerText = 'Rec On'
        e.target.style.backgroundColor = 'cadetblue'
        $('#rec_user').val(1);
    } else {
        var meetingId = $('#user_meeting').val();
        if (meetingId == 0) {
            alert('Please wait while fetching recording id....');
            return;
        }
        await (stopRecordingFromResource());
        e.target.innerText = 'Rec Off'
        e.target.style.backgroundColor = '#EE4828'
        $('#rec_user').val(0);
    }
}

document.getElementById('join-btn2').addEventListener('click', joinStream)
document.getElementById('leave-btn').addEventListener('click', leaveAndRemoveLocalStream)
document.getElementById('mic-btn').addEventListener('click', toggleMic)
document.getElementById('camera-btn').addEventListener('click', toggleCamera)
//document.getElementById('rec-btn').addEventListener('click', togglerecording)