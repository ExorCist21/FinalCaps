<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemFeedbacks extends Model
{
    use HasFactory;

    protected $table = 'system_feedbacks';
    protected $primaryKey = 'feedbackID';

    protected $fillable = [
        'userID',
        'system_feedback',
        'system_rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
