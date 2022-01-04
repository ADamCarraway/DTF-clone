<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('new-comment.{category_id}', function () {
    return true;
});

Broadcast::channel('new-post-counter.{category_id}', function () {
    return true;
});
