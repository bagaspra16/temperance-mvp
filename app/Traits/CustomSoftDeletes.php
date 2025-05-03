<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CustomSoftDeletes
{
    /**
     * Boot the custom soft deletes trait for a model.
     *
     * @return void
     */
    public static function bootCustomSoftDeletes()
    {
        static::addGlobalScope('not_deleted', function (Builder $builder) {
            $builder->where('deleted', false);
        });
    }

    /**
     * Force a hard delete on a soft deleted model.
     *
     * @return bool|null
     */
    public function forceDelete()
    {
        return $this->delete();
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return mixed
     */
    protected function performDeleteOnModel()
    {
        $this->deleted = true;
        return $this->save();
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function restore()
    {
        $this->deleted = false;
        return $this->save();
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function trashed()
    {
        return $this->deleted === true;
    }
    
    /**
     * Get a new query builder that includes soft-deleted models.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function withTrashed()
    {
        return $this->withoutGlobalScope('not_deleted');
    }
    
    /**
     * Get a new query builder that only includes soft-deleted models.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function onlyTrashed()
    {
        return $this->withoutGlobalScope('not_deleted')->where('deleted', true);
    }
} 