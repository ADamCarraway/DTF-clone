<?php

namespace App\Concerns;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Notifiable
{
    public function notifiable(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
