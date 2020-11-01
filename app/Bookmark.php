<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function bookmarkable()
    {
        return $this->morphTo();
    }
}
