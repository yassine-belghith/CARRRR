<?php

namespace App\Policies;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransferPolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

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
    public function view(User $user, Transfer $transfer): bool
    {
        return $user->id === $transfer->user_id;
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
    public function update(User $user, Transfer $transfer): bool
    {
        return false; // Handled by before() for admins
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transfer $transfer): bool
    {
        return false; // Handled by before() for admins
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transfer $transfer): bool
    {
        return false; // Handled by before() for admins
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transfer $transfer): bool
    {
        return false; // Handled by before() for admins
    }
}
