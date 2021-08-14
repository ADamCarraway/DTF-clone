<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Views extends Model
{
    protected $table = 'viewable';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $guarded = [];

    public function viewable()
    {
        return $this->morphTo();
    }
}
