<?php

namespace App\Models;

use App\Notifications\AddCommentNotification;
use App\Notifications\AddFollowNotification;
use App\Notifications\AddLikeToCommentNotification;
use App\Notifications\AddLikeToPostNotification;
use App\Notifications\AddPostNotification;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    const NOTIFICATIONS = [
        AddCommentNotification::class,
        AddFollowNotification::class,
        AddLikeToCommentNotification::class,
        AddLikeToPostNotification::class,
        AddPostNotification::class
    ];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
