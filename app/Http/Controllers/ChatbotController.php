<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function chat()
    {
        return view('chatbot.index');
    }

    public function sendMessage(Request $request)
    {
        $message = $request->message;

        // Basic chatbot responses
        $responses = [
            'hello' => 'Hi there! How can I assist you today?',
            'how to book' => 'Navigate to the "Therapist" tab and browse for available therapists. You can filter them by expertise.',
            'help' => 'I can help you find a therapist. What issue are you facing?',
            'booking' => 'To book a therapist, go to the "Book Appointment" page and select a date and time.',
            'stress' => 'If you’re feeling stressed, I recommend booking a therapist who specializes in stress management.',
            'depression' => 'If you’re feeling depressed, you may want to talk to a therapist specializing in depression counseling.',
            'anxiety' => 'For anxiety, you can talk to a therapist who specializes in anxiety management. It’s okay to ask for support!',
            'relationships' => 'For relationship issues, I recommend seeking a therapist who specializes in relationship counseling and therapy.',
            'self-care' => 'Self-care is essential. A therapist specializing in self-care can help you create better habits and routines.',
            'mental health' => 'If you’re concerned about your mental health, there are many therapists who can guide you with mental health support and coping strategies.',
            'bipolar' => 'Bipolar disorder is manageable with the right support. A therapist specializing in mood disorders can help you manage symptoms.',
            'ptsd' => 'For PTSD, seeking a therapist specializing in trauma counseling is important. Therapy can help you process your experiences in a safe environment.',
            'self-improvement' => 'If you’re looking to improve yourself, there are therapists who specialize in personal development and self-growth.',
            'how to choose a therapist' => 'To choose the right therapist, consider their expertise and experience with your specific concerns, like stress, anxiety, or relationships.',
            'payment' => 'If you’re concerned about payment, please go to the "Buy Sessions" page where you can purchase more sessions or check your payment status.',
            'session availability' => 'To see therapist availability, go to the "Book Appointment" page and select the date and time that works best for you.',
            'cancel appointment' => 'To cancel your appointment, please go to your appointment list and select the cancel option for that appointment.',
            'book appointment' => 'To book an appointment, go to the "Book Appointment" page, choose a therapist, and pick a time that works best for you.',
            'therapist expertise' => 'You can view therapist expertise in their profiles. We offer therapists specializing in stress, depression, relationships, and more.',
            'how to book again' => 'If you wish to book again, go to the "Appointments" page and click on "Book Appointment" for another therapist.',
            'progress tracking' => 'To track your progress, you can review your past sessions and notes with your therapist through the "Progress" tab.',
            'online therapy' => 'Yes, online therapy sessions are available. You can book an online session by selecting it during the booking process.',
            'therapist location' => 'You can find therapist locations or online consultation options on their profiles in the "Therapists" section.',
            'find a therapist' => 'To find a therapist, visit the "Therapists" section where you can browse through various options based on your needs.',
            'book therapist' => 'To book a therapist, head over to the "Therapists" section, select a therapist, and book a session based on their availability.',
            'cancel booking' => 'To cancel your booking, navigate to your appointment page and select the cancel option next to your upcoming session.',
            'find help' => 'If you need help finding the right therapist, let me know your concern, and I can help recommend a therapist for you.',
            'psychologist vs therapist' => 'A psychologist focuses on mental health through assessments, therapy, and counseling. A therapist can offer various therapeutic approaches for emotional or behavioral issues.',
        ];
        

        $reply = 'I am not sure how to respond to that. Can you please rephrase?';
        foreach ($responses as $key => $response) {
            if (strpos(strtolower($message), $key) !== false) {
                $reply = $response;
                break;
            }
        }

        return response()->json(['reply' => $reply]);
    }
}
