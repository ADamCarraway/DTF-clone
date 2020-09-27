<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $appends = ['is_notify'];

    public function users()
    {
        return $this->hasMany(Subscription::class);
    }

    public function notify()
    {
        return SubsNotify::query()->where([
            'subs_notify_type' => Category::class,
            'subs_notify_id' => $this->id
        ])->get();
    }

    public function getIsNotifyAttribute()
    {
        if (!auth()->check()) return false;

        return $this->notify()->where('user_id', auth()->id())->count() != 0;
    }
}
