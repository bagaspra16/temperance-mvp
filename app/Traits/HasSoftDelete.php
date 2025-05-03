<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait HasSoftDelete
{
    use SoftDeletes;

    /**
     * Boot the trait.
     */
    protected static function bootHasSoftDelete()
    {
        static::addGlobalScope('notDeleted', function ($builder) {
            $builder->where('deleted', false);
        });
    }
} 