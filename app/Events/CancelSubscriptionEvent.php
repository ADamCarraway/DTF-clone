<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CancelSubscriptionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $type;
    public $slug;

    public function __construct($slug, $type)
    {
        $this->type = $type;
        $this->slug = $slug;
    }
}
