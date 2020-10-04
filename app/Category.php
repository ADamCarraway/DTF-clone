<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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

        return auth()->user()->categoryIgnore()->where('ignoreable_id', $this->id)->exists();
    }

    public function getIsNotifyAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->categoryNotify()->where('subs_notify_id', $this->id)->exists();
    }
}
