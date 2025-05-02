<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'isActive',
        'session_left',
    ];

    protected $dates = ['email_verified_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function conversations()
    {
        
        return $this->hasMany(Conversation::class,'sender_id')->orWhere('receiver_id',$this->id)->whereNotDeleted();
    }

    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.'.$this->id;
    }

    public function therapistInformation()
    {
        return $this->hasOne(TherapistInformation::class, 'user_id');
    }

    public function appointmentsAsTherapist()
    {
        return $this->hasMany(Appointment::class, 'therapist_id');
    }

    public function appointmentsAsPatient()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'therapist_id');
    }

    public function systemfeedback()
    {
        return $this->hasMany(SystemFeedbacks::class, 'userID');
    }
    public function issuedInvoices()
    {
        return $this->hasMany(Invoice::class, 'therapist_id');
    }

    // Patient's invoices
    public function receivedInvoices()
    {
        return $this->hasMany(Invoice::class, 'patient_id');
    }
    public function getUserMeetingInfo() {
        return $this->hasOne(UserMeeting::class, 'user_id','id');
    }
}
