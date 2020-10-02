<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $appends = ['is_notify', 'type'];

    public function getIsNotifyAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->categoriesNotify->where('notify_id', $this->id)->count() != 0;
    }

    public function getTypeAttribute()
    {
        return 'category';
    }

    public function users()
    {
        return $this->morphToMany(User::class, 'subscription');
    }
}
