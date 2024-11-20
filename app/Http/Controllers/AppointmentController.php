<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    //
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'datetime' => 'required|date',
            'description' => 'required|string|max:255',
            'therapist_id' => 'required|exists:users,id',
        ]);

        // Create a new appointment
        $patient = Appointment::create([
            'datetime' => $request->datetime,
            'description' => $request->description,
            'therapistID' => $request->therapist_id,
            'patientID' => Auth::id(), // therapist's ID
            'created_at' => now(),
            'updated_at' => now(),
            'status' => 'pending',
            'session_meeting' => null,
        ]);

        $patientName = Auth::user()->name;

        Notification::create([
            'n_userID' => $request->therapist_id,  // Notify the therapist
            'type' => 'appointment',  // You can define this type for negotiation
            'data' => $patientName, // Custom message
            'created_at' => now(),
        ]);
        // Redirect with success message
        return redirect()->route('patients.appointment')->with('success', 'Appointment successfully booked!');
    }

    public function cancelApp($appointmentID)
    {
        // Fetch the appointment using the provided appointment ID
        $appointment = Appointment::where('appointmentID', $appointmentID)
            ->where('patientID', Auth::id()) // Ensure the patient is the owner of the appointment
            ->first();

        // Check if the appointment exists
        if (!$appointment) {
            return redirect()->route('patients.appointment')->with('error', 'Appointment not found or you do not have permission to cancel this appointment.');
        }

        // Delete the appointment
        $appointment->delete();

        // Redirect with a success message
        return redirect()->route('patients.appointment')->with('success', 'Appointment successfully canceled!');
    }

    public function index()
    {
        // Fetch the patient's upcoming appointments along with therapist data
        $upcomingAppointments = Appointment::where('therapistID', Auth::id())
            ->where('status', 'approved')
            ->where('isDone', false)
            ->with('patient')
            ->get();

        $doneAppointments = Appointment::where('therapistID', Auth::id())
            ->where('status', 'approved')
            ->where('isDone', true)
            ->with('patient')
            ->get();

        return view('therapist.therapist-index', compact('upcomingAppointments', 'doneAppointments'));
    }

    public function indexPatient()
    {
        // Fetch the patient's upcoming appointments along with therapist data
        $appointments = Appointment::where('patientID', Auth::id())
            ->where('status', 'approved')
            ->with('therapist')
            ->get();

        return view('patients.patient-index', compact('appointments'));
    }

    /**
     * Show the form for setting the consultation schedule for a specific appointment.
     */
    public function viewSession($appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);

        // Ensure the therapist is the one managing the appointment
        if ($appointment->therapistID !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('therapist.view-session', compact('appointment'));
    }

    public function storeSession(Request $request, $appointmentId)
    {
        $request->validate([
            'meeting_type' => 'required|in:online,in-person',
            'session_meeting' => 'required|string|max:255',
        ]);

        $appointment = Appointment::findOrFail($appointmentId);

        // Ensure the therapist is the one managing the appointment
        if ($appointment->therapistID !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Update the appointment with the meeting type and details
        $appointment->update([
            'meeting_type' => $request->meeting_type,
            'session_meeting' => $request->session_meeting,
        ]);

        return redirect()->route('therapist.session')->with('success', 'Consultation details updated successfully!');
    }
}
