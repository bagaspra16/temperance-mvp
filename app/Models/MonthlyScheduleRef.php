<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomSoftDeletes;

class MonthlyScheduleRef extends Model
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
        'monthly_template_id',
        'weekly_template_id',
        'week_of_month',
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
        'week_of_month' => 'integer',
        'deleted' => 'boolean',
    ];

    /**
     * Get the monthly template that this reference belongs to.
     */
    public function monthlyTemplate()
    {
        return $this->belongsTo(ScheduleTemplate::class, 'monthly_template_id');
    }

    /**
     * Get the weekly template that this reference points to.
     */
    public function weeklyTemplate()
    {
        return $this->belongsTo(ScheduleTemplate::class, 'weekly_template_id');
    }
}
