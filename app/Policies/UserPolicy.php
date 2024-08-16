<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        Log::info('Checking update permission', [
            'user_id' => $user->id,
            'model_id' => $model->id,
            'is_admin' => $user->hasRole('admin'),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
        return $user->hasRole('admin') || $user->id === $model->id;
        // return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole('admin') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, User $model)
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, User $model)
    // {
    //     //
    // }
}
