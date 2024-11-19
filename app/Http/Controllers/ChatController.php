<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a list of therapists for the patient to select.
     */
    public function index()
    {
        // Fetch the patient's upcoming appointments along with therapist data
        $appointments = Appointment::where('patientID', Auth::id())
            ->where('status', 'approved')
            ->with('therapist')  // Eager load the therapist
            ->get();

        return view('chat.index', compact('appointments'));
    }

    public function therapistIndex()
    {
        // Fetch the patient's upcoming appointments along with therapist data
        $appointments = Appointment::where('therapistID', Auth::id())
            ->where('status', 'approved')
            ->with('patient')  // Eager load the therapist
            ->get();

        return view('chat.therapist-index', compact('appointments'));
    }

    public function showTherapist($patientId, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $patient = User::findOrFail($patientId);

        // Ensure the therapist is the one who has access
        if ($appointment->therapistID !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if a conversation exists between the patient and therapist
        $conversation = Conversation::where(function ($query) use ($appointment) {
            $query->where('sender_id', $appointment->patientID)
                ->where('receiver_id', Auth::id());
        })->orWhere(function ($query) use ($appointment) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $appointment->patientID);
        })->first();

        // If no conversation exists, create a new one
        if (!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => $appointment->patientID,
                'receiver_id' => Auth::id(),
                'appointment_id' => $appointment->appointmentId,
            ]);
        }

        // Fetch messages for the conversation
        $messages = $conversation->messages;

        return view('chat.therapist-chat', compact('conversation', 'messages', 'patient', 'appointment'));
    }

    /**
     * Show the chat for the selected therapist and appointment.
     */
    public function show($therapistId, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $therapist = User::findOrFail($therapistId);

        // Ensure the patient is the one who booked the appointment
        if ($appointment->patientID !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if a conversation exists between the patient and therapist
        $conversation = Conversation::where(function ($query) use ($appointment) {
            $query->where('sender_id', Auth::id())
                ->where('receiver_id', $appointment->therapistID);
        })->orWhere(function ($query) use ($appointment) {
            $query->where('sender_id', $appointment->therapistID)
                ->where('receiver_id', Auth::id());
        })->first();

        // If no conversation exists, create a new one
        if (!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $appointment->therapistID,
                'appointment_id' => $appointment->appointmentId,
            ]);
        }

        // Fetch messages for the conversation
        $messages = $conversation->messages;

        return view('chat.chat', compact('conversation', 'messages', 'therapist', 'appointment'));
    }

    /**
     * Send a message to the conversation.
     */
    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $conversation = Conversation::findOrFail($conversationId);

        // Ensure the authenticated user is part of the conversation
        if ($conversation->sender_id !== Auth::id() && $conversation->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Store the message
        Message::create([
            'conversation_id' => $conversation->id,
            'receiver_id' => $conversation->receiver_id,
            'sender_id' => Auth::id(),
            'body' => $request->message,
        ]);

        return back();
    }
    public function fetchMessages(Request $request, $conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);

        if ($conversation->sender_id !== Auth::id() && $conversation->receiver_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $lastMessageId = $request->query('lastMessageId', 0);
        $messages = $conversation->messages()->where('id', '>', $lastMessageId)->get();

        return response()->json($messages);
    }

}
