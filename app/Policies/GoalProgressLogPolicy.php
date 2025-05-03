<?php

namespace App\Policies;

use App\Models\GoalProgressLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GoalProgressLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GoalProgressLog  $progressLog
     * @return bool
     */
    public function view(User $user, GoalProgressLog $progressLog)
    {
        return $user->id === $progressLog->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GoalProgressLog  $progressLog
     * @return bool
     */
    public function update(User $user, GoalProgressLog $progressLog)
    {
        return $user->id === $progressLog->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GoalProgressLog  $progressLog
     * @return bool
     */
    public function delete(User $user, GoalProgressLog $progressLog)
    {
        return $user->id === $progressLog->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GoalProgressLog  $progressLog
     * @return bool
     */
    public function restore(User $user, GoalProgressLog $progressLog)
    {
        return $user->id === $progressLog->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\GoalProgressLog  $progressLog
     * @return bool
     */
    public function forceDelete(User $user, GoalProgressLog $progressLog)
    {
        return $user->id === $progressLog->user_id;
    }
} 