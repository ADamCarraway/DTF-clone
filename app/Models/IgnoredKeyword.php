<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IgnoredKeyword extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'keyword'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
