<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomSoftDeletes;

class WeeklyScheduleRef extends Model
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
        'weekly_template_id',
        'daily_template_id',
        'day_of_week',
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
     * Get the weekly template that this reference belongs to.
     */
    public function weeklyTemplate()
    {
        return $this->belongsTo(ScheduleTemplate::class, 'weekly_template_id');
    }

    /**
     * Get the daily template that this reference points to.
     */
    public function dailyTemplate()
    {
        return $this->belongsTo(ScheduleTemplate::class, 'daily_template_id');
    }
}
