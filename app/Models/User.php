<?php

namespace App\Models;

use App\Concerns\Bookmarks;
use App\Concerns\Ignored;
use App\Concerns\Likes;
use App\Concerns\Notifications as NotificationsTrait;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract;
use Hypefactors\Laravel\Follow\Contracts\CanFollowContract;
use Hypefactors\Laravel\Follow\Traits\CanBeFollowed;
use Hypefactors\Laravel\Follow\Traits\CanFollow;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Concerns\Ignorable;
use App\Concerns\Notifiable as NotifiableTrait;
use App\Contracts\Ignorable as IgnorableInterface;
use App\Contracts\Notifiable as NotifiableInterface;

class User extends Authenticatable implements JWTSubject, CanFollowContract, CanBeFollowedContract, NotifiableInterface, IgnorableInterface//, MustVerifyEmail
{
    use Likes,
        Bookmarks,
        CanFollow,
        CanBeFollowed,
        NotificationsTrait,
        NotifiableTrait,
        Ignored,
        Ignorable,
        Notifiable;

    //a - postLikes, b = commentsLikes
    const ODDS = ['a' => 0.02, 'b' => 0.05, 'c' => 1];

    const AVATAR_PATH = 'user/avatars/full/';
    const HEADER_PATH = 'user/headers/full/';
    const COMMENT_FILE_PATH = 'comment/files/full/';
    const POST_FILE_PATH = 'post/files/full/';

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password', 'remember_token', 'qr'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'oauthProviders',
    ];

    protected $appends = [
        'have_password',
        'icon',
        'title',
        'url',
        'is_ignore',
        'is_notify',
        'is_favorite',
        'is_follow',
        'type',
        'slug'
    ];


    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getHavePasswordAttribute()
    {
        return $this->password !== null;
    }

    protected function getSlugAttribute()
    {
        return $this->id . '-' . Str::slug($this->name);
    }

    public function getTypeAttribute()
    {
        return 'user';
    }

    public function getIconAttribute()
    {
        return $this->avatar;
    }

    public function getTitleAttribute()
    {
        return $this->name;
    }

    public function getUrlAttribute()
    {
        return 'u/' . $this->slug;
    }

    public function getIsIgnoreAttribute()
    {
        if (!auth()->check() || auth()->id() === $this->id) return false;

        return auth()->user()->ignored()->where('ignorable_type', self::class)->where('ignorable_id', $this->id)->exists();
    }

    public function getIsNotifyAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->follower_notifications()->where('notifiable_type', User::class)->where('notifiable_id', $this->id)->exists();
    }

    public function scopeWhereSlug(Builder $query, $slug)
    {
        return $query->where('id', (int)stristr($slug, '-', true));
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getIsFavoriteAttribute()
    {
        if (!auth()->check() || $this->id === auth()->user()->id) return false;

        $record = $this->findFollower(auth()->user());

        return $record ? (bool)$record->favorite : false;
    }

    public function getRatingAttribute()
    {
        $commentLikes = Like::query()->where('likeable_type', Comment::class)->whereIn('likeable_id', $this->comments()->pluck('id'))->count();
        $postsLikes = Like::query()->where('likeable_type', Post::class)->whereIn('likeable_id', $this->posts()->pluck('id'))->count();

        return round(self::ODDS['c'] + self::ODDS['a'] * Log(1 + $commentLikes) + self::ODDS['b'] * Log(1 + $postsLikes), 1);
    }

    public function getIsFollowAttribute()
    {
        if (!auth()->check() || $this->id === auth()->user()->id) return false;

        return $this->hasFollower(auth()->user());
    }

    public function toVueFormat(): array
    {
        return array_merge($this->toArray(), [
            'subscriptions'       => $subscriptions = $this->followings()
                ->with('followable')
                ->get()
                ->pluck('followable')
                ->keyBy('slug')
                ->sortByDesc('date')
                ->sortByDesc('is_favorite')
                ->toArray(),
            'subscribers'         => $this->followers()->with('follower')->limit(12)->get()->pluck('follower'),
            'followers_count'   => $this->followers()->count(),
            'followings_count' => $this->followings()->count(),
            'subscriptions_limit' => array_slice($subscriptions, 0, 5),
            'posts_count'         => $this->posts()->public()->count(),
            'comments_count'      => $this->comments()->count(),
            'bookmarks_count'     => $this->bookmarks()->count(),
            'notifications_count' => $this->notifications()
                ->whereNull('read_at')
                ->count(),
            'drafts_count'        => $this->posts()->draft()->count()
        ]);
    }

    public function notificationSettings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserNotificationSetting::class);
    }

    public function isNotificationEnabled($notification)
    {
        return $this->notificationSettings()->where('notification', $notification)->first()->status ?? 1;
    }
}
