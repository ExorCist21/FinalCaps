<?php

namespace App\Http\Controllers;

use App\Events\sendNotification;
use App\Models\MeetingEntry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserMeeting;
use Illuminate\Support\Facades\Session;
use App\Models\Appointment;

class MeetingController extends Controller
{
    public function meetinguser(Request $request) {
        $user = Auth::user();
        $appointmentID = $request->appointmentID; // Get appointmentID from URL or form

        if ($user->role == 'therapist') {
            // Therapist: get only the appointment they own
            $appointments = Appointment::where('therapistID', $user->id)
                                        ->with('patient','therapist')
                                        ->where('appointmentID', $appointmentID)
                                        ->get();
        } else {
            // Patient: get only the appointment they own
            $appointments = Appointment::where('patientID', $user->id)
                                        ->with('patient','therapist')
                                        ->where('appointmentID', $appointmentID)
                                        ->get();
        }

        return view('createMeeting', compact('appointments'));
    }

    public function createMeeting() {
        $meeting = Auth::user()->getUserMeetingInfo()->first();
    
        if (!$meeting) { // If no meeting exists
            $name = 'agora' . rand(1111, 9999);
    
            // Here you should create your Agora Project manually
            // But if you don't, you must set app_id and appCertificate yourself
            $appId = env('AGORA_APP_ID'); 
            $appCertificate = env('AGORA_APP_CERTIFICATE'); 
    
            $meeting = new UserMeeting();
            $meeting->user_id = Auth::user()->id;
            $meeting->app_id = $appId;
            $meeting->appCertificate = $appCertificate;
            $meeting->channel = $name;
            $meeting->uid = rand(1111, 9999);
            $meeting->save();
        }
    
        // Reload after creating
        $meeting = Auth::user()->getUserMeetingInfo()->first();
    
        // Now create the token
        $token = createToken($meeting->app_id, $meeting->appCertificate, $meeting->channel);
    
        $meeting->token = $token;
        $meeting->url = generateRandomString();
        $meeting->event = generateRandomString(5);
        $meeting->save();
    
        if (Auth::user()->id == $meeting->user_id) {
            Session::put('meeting', $meeting->url);
        }
    
        return redirect('joinMeeting/' . $meeting->url);
    }

    public function joinMeeting($url='') {
        $meeting = UserMeeting::where('url', $url)->first();
        //meeting exist
        if(isset($meeting->id)) {
            $meeting->app_id = trim($meeting->app_id);
            $meeting->appCertificate = trim($meeting->appCertificate);
            $meeting->channel = trim($meeting->channel);
            $meeting->token = trim($meeting->token);
            // create meeting
            if(Auth::User() && Auth::User()->id == $meeting->user_id) {
                $channel = $meeting->channel;
                $event = $meeting->event;
            } else {
                if(!Auth::user()) {
                    //wont
                    $random_user = rand(111111,999999);
                    Session::put('random_user', $random_user);
                    $event = generateRandomString(5);

                    $this->createEntry($meeting->user_id, $random_user, $meeting->url, $event, $meeting->channel, 'Guest');
                    $channel = $meeting->channel;

                } else {
                    $random_user = rand(111111,999999);
                    Session::put('random_user', $random_user);
                    $event = generateRandomString(5);
                    $this->createEntry($meeting->user_id, Auth::User()->id , $meeting->url, $event, $meeting->channel, Auth::user()->name ?? 'User');
                    $channel = $meeting->channel;
                    //Session::put('random_user', Auth::User()-id);
                }
            }
            //prx(get_defined_vars());
            return view('joinUser', get_defined_vars());
        } else {
            // dont exist
        }
    }

    public function createEntry($user_id, $random_user, $url ,$event, $channel, $name) {
        $entry = new MeetingEntry();
        $entry->user_id = $user_id;
        $entry->random_user = $random_user;
        $entry->name = $name;
        $entry->url = $url; // FIX THIS LATER PLEASE
        $entry->status = 0;
        $entry->event = $event;
        $entry->channel = $channel;
        $entry->save();
    }

    public function saveUserName(Request $request) {
        $saveName = MeetingEntry::where(['random_user'=>$request->random, 'url'=>$request->url])->first();
        
        if($saveName->status == 3) {
            
        } else {
            $saveName->name = $request->name;
            $saveName->status = 1;
            $saveName->save();

            $meeting = UserMeeting::where('url', $request->url)->first();
            $data = ['random_user'=>$request->random, 'title'=> $saveName->name . ' wants to enter the meeting.'];
            event(new sendNotification($data, $meeting->channel, $meeting->event));
        }
    }

    public function meetingApprove(Request $request) {
        $saveName = MeetingEntry::where(['random_user' => $request->random, 'url' => $request->url])->first();
        if ($saveName) {
            $saveName->status = $request->type;
            if ($request->type == 2) {
                $saveName->created_at = date("Y-m-d h:i:s");
                $saveName->updated_at = date("Y-m-d h:i:s");
            }
            $saveName->save();
    
            $data = ['status' => $request->type, 'random' => $request->random];
            event(new sendNotification($data, $saveName->channel, $saveName->event));
        }
    }
    
    public function callRecordTime(Request $request) {
        $saveName = MeetingEntry::where(['random_user' => $request->random, 'url' => $request->url])->first();
        if ($saveName) {
            $saveName->updated_at = date("Y-m-d h:i:s");
            $saveName->save();
        }
    
        return response()->json(['status' => 'success', 'msg' => 'time added']);
    }
}
