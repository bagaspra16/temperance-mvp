<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\CustomSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
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
        'goal_id',
        'category_id',
        'title',
        'schedule',
        'active',
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
        'schedule' => 'array',
        'active' => 'boolean',
        'deleted' => 'boolean',
    ];

    /**
     * Get the user that owns the habit.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the goal that the habit belongs to.
     */
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    /**
     * Get the category of the habit.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the habit logs for this habit.
     */
    public function logs()
    {
        return $this->hasMany(HabitLog::class);
    }

    /**
     * Get the reminders for this habit.
     */
    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'related_habit_id');
    }

    /**
     * Check if habit is scheduled for a specific day of week (1 = Monday, 7 = Sunday).
     *
     * @param int $dayOfWeek
     * @return bool
     */
    public function isScheduledForDay($dayOfWeek)
    {
        return isset($this->schedule['days']) && in_array($dayOfWeek, $this->schedule['days']);
    }

    /**
     * Get completion rate for this habit.
     *
     * @return float
     */
    public function getCompletionRate()
    {
        $totalLogs = $this->logs()->count();
        if ($totalLogs === 0) {
            return 0;
        }
        
        $completedLogs = $this->logs()->where('status', true)->count();
        return ($completedLogs / $totalLogs) * 100;
    }

    /**
     * Check if the habit has been completed today.
     *
     * @return bool
     */
    public function completedToday()
    {
        $today = now()->toDateString();
        $log = $this->logs()->where('log_date', $today)->first();
        
        return $log && $log->status;
    }

    /**
     * Get the name of the habit (alias for title).
     */
    public function getNameAttribute()
    {
        return $this->title;
    }
}
