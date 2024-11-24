<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'subscription_id',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'proof'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    public function getProofUrlAttribute()
    {
        return asset('storage/' . $this->proof); 
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'transaction_id', 'appointmentID');
    }
}
