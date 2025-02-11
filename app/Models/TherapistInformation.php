<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistInformation extends Model
{
    use HasFactory;

    protected $table = 'therapist_informations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'awards',
        'clinic_name',
        'expertise',
        'occupation',
        'contact_number',
        'gcash_number',
    ];

    public function therapist()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
