<?php

namespace App;

use Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract;
use Hypefactors\Laravel\Follow\Traits\CanBeFollowed;
use Illuminate\Database\Eloquent\Model;

class Category extends Model implements CanBeFollowedContract, Contracts\Ignorable, Contracts\Notifiable
{
    use CanBeFollowed, Concerns\Ignorable, Concerns\Notifiable;

    protected $appends = ['is_notify', 'type', 'url', 'is_ignore'];

    public function getTypeAttribute()
    {
        return 'category';
    }

    public function subscribers()
    {
        return $this->morphToMany(User::class, 'subscription');
    }

    public function getUrlAttribute()
    {
        return $this->slug;
    }

    public function getIsIgnoreAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->ignored()->where('ignorable_type', self::class)->where('ignorable_id', $this->id)->exists();
    }

    public function getIsNotifyAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->notifications()->where('notifiable_type', Category::class)->where('notifiable_id', $this->id)->exists();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
