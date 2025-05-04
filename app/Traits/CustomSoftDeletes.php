<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CustomSoftDeletes
{
    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootCustomSoftDeletes()
    {
        static::addGlobalScope('notDeleted', function ($builder) {
            $builder->where('deleted', false);
        });
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    public function delete()
    {
        if ($this->exists) {
            $this->deleted = true;
            $this->save();
        }
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function restore()
    {
        if ($this->exists) {
            $this->deleted = false;
            return $this->save();
        }

        return false;
    }

    /**
     * Force delete the model.
     *
     * @return bool|null
     */
    public function forceDelete()
    {
        return parent::delete();
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