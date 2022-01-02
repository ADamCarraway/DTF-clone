<?php

namespace App\Models;

use App\Notifications\AddCommentNotification;
use App\Notifications\AddFollowNotification;
use App\Notifications\AddLikeToCommentNotification;
use App\Notifications\AddPostNotification;
use App\Notifications\AddReplyCommentNotification;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    const NOTIFICATIONS = [
        AddCommentNotification::class,
        AddFollowNotification::class,
        AddLikeToCommentNotification::class,
        AddPostNotification::class,
        AddReplyCommentNotification::class
    ];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
