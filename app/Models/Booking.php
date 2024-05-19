<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_id',
        'start_date',
        'end_date',
        'status',
        'price'
    ];

    public $timestamps = false;
}
