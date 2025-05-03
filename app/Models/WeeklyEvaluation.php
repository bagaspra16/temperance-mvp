<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\CustomSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyEvaluation extends Model
{
    use HasFactory, HasUuid, CustomSoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'week_start',
        'week_end',
        'achievement',
        'challenge',
        'improvement_plan',
        'rating',
        'deleted',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'week_start' => 'date',
        'week_end' => 'date',
        'rating' => 'integer',
        'deleted' => 'boolean',
    ];

    /**
     * Get the user that owns the weekly evaluation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the habits completed during this week.
     */
    public function habitLogs()
    {
        return $this->hasManyThrough(
            HabitLog::class,
            User::class,
            'id', // Foreign key on users table
            'user_id', // Foreign key on habit_logs table
            'user_id', // Local key on weekly_evaluations table
            'id' // Local key on users table
        )->whereBetween('log_date', [$this->week_start, $this->week_end]);
    }
}
