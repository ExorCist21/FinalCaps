<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AgoraTokenGenerator;
use App\Models\Appointment; // adjust if different model

class VideoCallController extends Controller
{
    public function showVideoCallPage($appointmentID)
    {
        $appointment = Appointment::findOrFail($appointmentID);

        return view('appointment.show', [
            'appointmentID' => $appointmentID,
            'patientName' => $appointment->patient->name  ?? 'Unknown',
            'therapistName' => $appointment->therapist->name ?? 'Unknown',
        ]);
    }

    public function generateAgoraToken($appointmentID)
    {
        $appId = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $channelName = 'appointment_' . $appointmentID;
        $uid = auth()->id();
        $expireTimeInSeconds = 3600;

        $token = AgoraTokenGenerator::buildTokenWithUid($appId, $appCertificate, $channelName, $uid, 1, $expireTimeInSeconds);

        return response()->json([
            'token' => $token,
            'appId' => $appId,
            'channelName' => $channelName,
            'uid' => $uid,
        ]);
    }
}
