<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomSoftDeletes;

class YearlyScheduleRef extends Model
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
        'yearly_template_id',
        'monthly_template_id',
        'month',
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
        'month' => 'integer',
        'deleted' => 'boolean',
    ];

    /**
     * Get the yearly template that this reference belongs to.
     */
    public function yearlyTemplate()
    {
        return $this->belongsTo(ScheduleTemplate::class, 'yearly_template_id');
    }

    /**
     * Get the monthly template that this reference points to.
     */
    public function monthlyTemplate()
    {
        return $this->belongsTo(ScheduleTemplate::class, 'monthly_template_id');
    }
}
