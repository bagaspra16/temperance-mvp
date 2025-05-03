<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomSoftDeletes;

class Reminder extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

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
        'related_habit_id',
        'reminder_text',
        'reminder_time',
        'repeat_days',
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
        'reminder_time' => 'datetime',
        'repeat_days' => 'array',
        'deleted' => 'boolean',
    ];

    /**
     * Get the user that owns the reminder.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the habit related to this reminder.
     */
    public function habit()
    {
        return $this->belongsTo(Habit::class, 'related_habit_id');
    }

    /**
     * Check if reminder is scheduled for a specific day of week (1 = Monday, 7 = Sunday).
     *
     * @param int $dayOfWeek
     * @return bool
     */
    public function isScheduledForDay($dayOfWeek)
    {
        return !$this->repeat_days || in_array($dayOfWeek, $this->repeat_days);
    }
}
