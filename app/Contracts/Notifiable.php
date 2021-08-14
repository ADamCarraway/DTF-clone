<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Notifiable
{
    public function notifiable(): MorphMany;
}
