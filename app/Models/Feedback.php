<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $primaryKey = 'id';

    protected $fillable = [
        'appointment_id','patient_id', 'therapist_id', 'feedback','rating'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }
}