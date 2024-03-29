<?php

namespace App\Providers;

use App\Events\CancelSubscriptionEvent;
use App\Events\CommentCreated;
use App\Events\PostCreated;
use App\Listeners\AddCommentNotifyToLiveLenta;
use App\Listeners\AddCommentNotify;
use App\Listeners\AddNotifyToUser;
use App\Listeners\AddPostNotify;
use App\Listeners\AddPostNotifyNewCounter;
use App\Listeners\AddSubsToUser;
use App\Listeners\UserNotifyRemove;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            AddSubsToUser::class,
            AddNotifyToUser::class
        ],

        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\\Twitch\\TwitchExtendSocialite@handle',
            'SocialiteProviders\\Facebook\\FacebookExtendSocialite@handle',
            'SocialiteProviders\\Google\\GoogleExtendSocialite@handle',
            \SocialiteProviders\VKontakte\VKontakteExtendSocialite::class.'@handle',
        ],

        CancelSubscriptionEvent::class => [
            UserNotifyRemove::class
        ],

        CommentCreated::class => [
            AddCommentNotifyToLiveLenta::class,
            AddCommentNotify::class
        ],

        PostCreated::class => [
            AddPostNotify::class,
            AddPostNotifyNewCounter::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
