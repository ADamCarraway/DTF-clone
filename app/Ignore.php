<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ignore extends Model
{
    protected $table = 'ignorable';
    protected $guarded = ['id'];

    public function ignorable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
