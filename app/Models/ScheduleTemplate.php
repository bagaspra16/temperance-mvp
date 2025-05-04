<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomSoftDeletes;

class ScheduleTemplate extends Model
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
        'name',
        'type',
        'description',
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
        'deleted' => 'boolean',
    ];

    /**
     * Get the user that owns the schedule template.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the daily tasks for this template.
     */
    public function dailyTasks()
    {
        return $this->hasMany(DailyTask::class, 'template_id');
    }

    /**
     * Get the weekly references where this template is used as a weekly template.
     */
    public function weeklyReferences()
    {
        return $this->hasMany(WeeklyScheduleRef::class, 'weekly_template_id');
    }

    /**
     * Get the weekly references where this template is used as a daily template.
     */
    public function dailyReferences()
    {
        return $this->hasMany(WeeklyScheduleRef::class, 'daily_template_id');
    }

    /**
     * Get the monthly references where this template is used as a monthly template.
     */
    public function monthlyReferences()
    {
        return $this->hasMany(MonthlyScheduleRef::class, 'monthly_template_id');
    }

    /**
     * Get the monthly references where this template is used as a weekly template.
     */
    public function weeklyInMonthReferences()
    {
        return $this->hasMany(MonthlyScheduleRef::class, 'weekly_template_id');
    }

    /**
     * Get the yearly references where this template is used as a yearly template.
     */
    public function yearlyReferences()
    {
        return $this->hasMany(YearlyScheduleRef::class, 'yearly_template_id');
    }

    /**
     * Get the yearly references where this template is used as a monthly template.
     */
    public function monthlyInYearReferences()
    {
        return $this->hasMany(YearlyScheduleRef::class, 'monthly_template_id');
    }
}
