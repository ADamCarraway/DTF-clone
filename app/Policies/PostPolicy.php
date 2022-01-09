<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Post $post)
    {
        return $user->id == $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        return $user->id == $post->user_id;
    }

    public function unpublish(User $user, Post $post)
    {
        return $user->id == $post->user_id;
    }
}
