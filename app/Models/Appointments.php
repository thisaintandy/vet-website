<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Add this line

class Appointments extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'user_id',
        'pet_name',
        'appointment_type',
        'appointment_date',
        'description',
        'status',
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

