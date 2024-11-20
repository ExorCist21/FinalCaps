<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $table = 'progress';

    protected $primaryKey = 'id';

    protected $fillable = [
        'appointment_id',
        'mental_condition',
        'mood',
        'symptoms',
        'remarks',
        'risk',
        'status',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'appointmentID');
    }
}
