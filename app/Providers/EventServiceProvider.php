<?php

namespace App\Providers;

use App\Events\CancelSubscriptionEvent;
use App\Events\CommentCreated;
use App\Events\PostCreated;
use App\Listeners\AddCommentNotifyToAuthor;
use App\Listeners\AddCommentNotifyToLiveLenta;
use App\Listeners\AddNotifyToUser;
use App\Listeners\AddPostNotify;
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
            'SocialiteProviders\\Twitter\\TwitterExtendSocialite@handle',
            'SocialiteProviders\\Facebook\\FacebookExtendSocialite@handle',
            'SocialiteProviders\\Google\\GoogleExtendSocialite@handle',
        ],

        CancelSubscriptionEvent::class => [
            UserNotifyRemove::class
        ],

        CommentCreated::class => [
            AddCommentNotifyToAuthor::class,
            AddCommentNotifyToLiveLenta::class
        ],

        PostCreated::class => [
            AddPostNotify::class
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
