<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $primaryKey = 'notificationID';

    protected $fillable = ['n_userID','read_at','data', 'type'];

    public $timestamps = true;

    public function patient() {
        return $this->belongsTo(User::class, 'id');
    }
    public function therapist()
    {
        return $this->belongsTo(User::class, 'id');
    }

}
