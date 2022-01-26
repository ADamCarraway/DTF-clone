<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAll(User $user)
    {
        return $user->can('view all users');
    }

    public function show(User $user)
    {
        return $user->can('view user');
    }

    public function changeRole(User $user)
    {
        return $user->can('change user role');
    }

    public function ban(User $user)
    {
        return $user->can('ban user');
    }

    public function update(User $user)
    {
        return $user->can('update user');
    }

    public function delete(User $user)
    {
        return $user->can('delete user');
    }
}
