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
        'appointment_id', 'disease', 'disease_type', 'fatal', 'remarks', 'status'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
