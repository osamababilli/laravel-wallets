<?php

namespace App\Policies;


use Illuminate\Auth\Access\Response;
use App\Models\User;

class LogsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view activity logs');
    }
}
