<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    info('u', [$user->id, $id]);
    return (int) $user->id === (int) $id;
});
