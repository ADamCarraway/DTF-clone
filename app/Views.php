<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    protected $table = 'views';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];

    public function viewable()
    {
        return $this->morphTo();
    }
}
