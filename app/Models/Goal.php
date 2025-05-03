<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\CustomSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
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
        'category_id',
        'title',
        'description',
        'type',
        'target_value',
        'unit',
        'start_date',
        'end_date',
        'completed',
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
        'start_date' => 'date',
        'end_date' => 'date',
        'target_value' => 'integer',
        'completed' => 'boolean',
        'deleted' => 'boolean',
    ];

    /**
     * Get the user that owns the goal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that the goal belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the habits associated with this goal.
     */
    public function habits()
    {
        return $this->hasMany(Habit::class);
    }

    /**
     * Get the progress logs for this goal.
     */
    public function progressLogs()
    {
        return $this->hasMany(GoalProgressLog::class);
    }

    /**
     * Calculate the current progress percentage.
     *
     * @return float
     */
    public function calculateProgress()
    {
        $totalProgress = $this->progressLogs()->sum('progress_value');
        
        return $this->target_value > 0 
            ? min(100, ($totalProgress / $this->target_value) * 100) 
            : 0;
    }
}
