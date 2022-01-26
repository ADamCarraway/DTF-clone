<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAll(User $user)
    {
        return $user->can('view all roles');
    }

    public function detachPermission(User $user)
    {
        return $user->can('detach permission');
    }

    public function update(User $user)
    {
        return $user->can('update role');
    }

    public function store(User $user)
    {
        return $user->can('create role');
    }

    public function destroy(User $user)
    {
        return $user->can('delete role');
    }
}
