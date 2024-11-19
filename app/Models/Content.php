<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'content';

    // The primary key of the table
    protected $primaryKey = 'content_id';

    // Disable automatic timestamp handling if your table doesn't have created_at and updated_at
    public $timestamps = true;

    // The attributes that are mass assignable
    protected $fillable = [
        'creatorID', // Foreign key for the user
        'description',
        'title',
        'url',
        'image_path',
    ];

    // Define the relationship to the User model
    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorID');
    }
    
}
