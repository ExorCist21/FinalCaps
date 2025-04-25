<?php
 
namespace App\Http\Controllers;
 
use App\Events\RequestVideoCall;
use App\Events\RequestVideoCallStatus;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class VideoCallController extends Controller
{
    public function index($appointmentID)
    {
        $authUser = auth()->user();

        // Retrieve the appointment along with the therapist and patient info
        $appointment = Appointment::with(['therapist', 'patient'])->findOrFail($appointmentID);

        // Determine the contact user (the other party in the appointment)
        $contactUser = $authUser->id === $appointment->therapist->id
            ? $appointment->patient
            : $appointment->therapist;

        return view('video-call.index', [
            'auth' => $authUser,
            'contactUser' => $contactUser,
            'appointment' => $appointment
        ]);
    }

    public function requestVideoCall(Request $request, User $user) 
    {
        $user->peerId = $request->peerId;
        $user->fromUser = Auth::user();
 
        broadcast(new RequestVideoCall($user));
  
        return response()->json($user);
    }
 
    public function requestVideoCallStatus(Request $request, User $user) {
        $user->peerId = $request->peerId;
        $user->fromUser = Auth::user();
 
        broadcast(new RequestVideoCallStatus($user));
        return response()->json($user);
    }
}