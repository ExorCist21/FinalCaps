<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function index()
    {
        // Get the authenticated user's ID
        $userId = auth()->id();

        // Pass it to the view
        return view('chat.index', ['userId' => $userId]);
    }

    public function fetchConversationList(Request $request)
    {
        $senderId = $request->input('sender_id');

        // Fetch the user's role
        $userRole = \DB::table('users')->where('id', $senderId)->value('role');

        // Initialize conversations
        $conversations = [];

        if ($userRole === 'patient') {
            // Fetch distinct therapists for the patient
            $conversations = \DB::table('appointments')
                ->join('users', 'users.id', '=', 'appointments.therapistID')
                ->where('appointments.patientID', $senderId)
                ->select('users.id', 'users.name', 'users.email') // Corrected table alias
                ->groupBy('users.id', 'users.name', 'users.email') // Added 'users.email' to groupBy
                ->orderBy(\DB::raw('MAX(appointments.updated_at)'), 'desc') // Corrected ordering
                ->get();
        } elseif ($userRole === 'therapist') {
            // Fetch distinct patients for the therapist
            $conversations = \DB::table('appointments')
                ->join('users', 'users.id', '=', 'appointments.patientID')
                ->where('appointments.therapistID', $senderId)
                ->select('users.id', 'users.name', 'users.email') // Corrected table alias
                ->groupBy('users.id', 'users.name', 'users.email') // Added 'users.email' to groupBy
                ->orderBy(\DB::raw('MAX(appointments.updated_at)'), 'desc') // Corrected ordering
                ->get();
        }

        return response()->json($conversations);
    }

    public function loadInitialMessages(Request $request)
    {
        $senderId = $request->input('sender_id');
        $receiverId = $request->input('receiver_id');
    
        // Fetch the latest 50 messages between the sender and receiver
        $initialMessages = Message::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $senderId);
        })->orderBy('created_at', 'asc')
          ->limit(50)
          ->get();
    
        // Return as a JSON response
        return response()->json($initialMessages);
    }    

    public function fetchUnreadMessages(Request $request)
    {
        $senderId = $request->input('sender_id');
        $receiverId = $request->input('receiver_id');
    
        // Fetch unread messages where read_at is NULL
        $unreadMessages = Message::where('receiver_id', $senderId)
                                 ->where('sender_id', $receiverId)
                                 ->whereNull('read_at')
                                 ->orderBy('created_at', 'asc')
                                 ->get();
    
        // Mark the fetched unread messages as read
        Message::where('receiver_id', $senderId)
               ->where('sender_id', $receiverId)
               ->whereNull('read_at')
               ->update(['read_at' => Carbon::now()]);
    
        return response()->json($unreadMessages);
    }
    
    // Send a new message
    public function sendMessage(Request $request)
    {
        try {
            // Log incoming request data
            \Log::info('SendMessage Request:', $request->all());

            // Validate input
            $request->validate([
                'sender_id' => 'required|exists:users,id',
                'receiver_id' => 'required|exists:users,id',
                'body' => 'required|string|max:5000',
            ]);

            // Create the message
            $message = Message::create([
                'sender_id' => $request->input('sender_id'),
                'receiver_id' => $request->input('receiver_id'),
                'body' => $request->input('body'),
                'created_at' => now(),
            ]);

            // Log successful creation
            \Log::info('Message Created:', $message->toArray());

            return response()->json($message);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error Sending Message:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to send message.'], 500);
        }
    }

    
}