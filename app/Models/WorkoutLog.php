<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workout_date',
        'workout_type',
        'duration',
        'distance',
        'notes',
    ];

    /**
     * Get the user that owns the workout log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
