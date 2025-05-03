<?php

namespace App\Models;

use App\Traits\HasUuid;
use App\Traits\CustomSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitLog extends Model
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
        'habit_id',
        'user_id',
        'log_date',
        'status',
        'note',
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
        'log_date' => 'date',
        'status' => 'boolean',
        'deleted' => 'boolean',
    ];

    /**
     * Get the habit that this log belongs to.
     */
    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }

    /**
     * Get the user that owns the habit log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
