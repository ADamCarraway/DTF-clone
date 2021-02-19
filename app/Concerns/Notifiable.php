<?php

namespace App\Concerns;

use App\Notification;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Notifiable
{
    public function notifiable(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
