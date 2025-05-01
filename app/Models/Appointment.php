<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $primaryKey = 'appointmentID';

    protected $fillable = [
        'datetime',
        'description',
        'risk_level',
        'therapistID',
        'patientID',
        'created_at',
        'updated_at',
        'status',
        'session_meeting',
        'meeting_type',
        'isDone'
    ];
    
    protected $dates = ['meeting_date'];
    
    public function patient()
    {
        return $this->belongsTo(User::class, 'patientID');
    }

    // Relationship to get the therapist
    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapistID');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'appointment_id');
    }
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'appointment_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'subscription_id', 'appointmentID');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'appointmentID');
    }

    public function meeting_channel()
    {
        return $this->hasOne(UserMeeting::has, 'url', 'session_meeting');
    }
}
