<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $appends = ['is_notify'];

    public function getIsNotifyAttribute()
    {
        if (!auth()->check()) return false;

        return auth()->user()->categoriesNotify->where('notify_id', $this->id)->count() != 0;
    }
}
