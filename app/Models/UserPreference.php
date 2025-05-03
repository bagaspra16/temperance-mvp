<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CustomSoftDeletes;

class UserPreference extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_date';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_date';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'theme',
        'accent_color',
        'email_notifications',
        'push_notifications',
        'weekly_summary',
        'default_view',
        'start_day',
        'date_format',
        'show_completed',
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
        'theme' => 'string',
        'accent_color' => 'string',
        'email_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'weekly_summary' => 'boolean',
        'default_view' => 'string',
        'start_day' => 'string',
        'date_format' => 'string',
        'show_completed' => 'boolean',
    ];

    /**
     * Get the user that owns these preferences.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
