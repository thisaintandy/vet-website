<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

