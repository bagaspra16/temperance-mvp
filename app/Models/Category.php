<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\CustomSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
        'name',
        'color_code',
        'icon',
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
     * Get the user that owns the category.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the goals associated with this category.
     */
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    /**
     * Get the daily tasks associated with this category.
     */
    public function dailyTasks()
    {
        return $this->hasMany(DailyTask::class);
    }

    /**
     * Get the color (alias for color_code).
     */
    public function getColorAttribute()
    {
        return $this->color_code;
    }
}
