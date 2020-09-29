<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubsNotify extends Model
{
    static $types = ['category' => Category::class, 'user' => User::class];

    protected $table = 'subs_notifies';
    protected $guarded = ['id'];
}
