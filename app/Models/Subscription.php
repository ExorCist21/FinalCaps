<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions'; // Specify the table name if it doesn't follow Laravel's conventions

    protected $primaryKey = 'id';

    protected $fillable = [
        'patient_id',
        'service_name',
        'duration',
        'status',
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'subscription_id');
    }


    public function patient()
    {
        return $this->belongsTo(User::class);
    }
}
