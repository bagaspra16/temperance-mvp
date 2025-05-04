<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\HasCreatorAndUpdater;
use App\Traits\CustomSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory, HasUuid, CustomSoftDeletes, HasCreatorAndUpdater;

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
        'title',
        'description',
        'category_id',
        'template_id',
        'start_time',
        'end_time'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_date' => 'datetime',
        'updated_date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'deleted' => 'boolean',
    ];

    /**
     * Get the template that owns this task.
     */
    public function template()
    {
        return $this->belongsTo(ScheduleTemplate::class, 'template_id');
    }

    /**
     * Get the category that owns the daily task.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the duration of the task in minutes.
     */
    public function getDurationMinutes()
    {
        if (!$this->start_time || !$this->end_time) {
            return 0;
        }

        return $this->start_time->diffInMinutes($this->end_time);
    }
}
