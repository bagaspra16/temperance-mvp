<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasCreatorAndUpdater
{
    /**
     * Boot the trait.
     */
    protected static function bootHasCreatorAndUpdater()
    {
        static::creating(function (Model $model) {
            if (!$model->created_by && auth()->check()) {
                $model->created_by = auth()->id();
            }
        });

        static::updating(function (Model $model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });
    }
} 