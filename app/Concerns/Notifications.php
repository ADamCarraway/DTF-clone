<?php

namespace App\Concerns;

use App\Contracts\Notifiable;
use App\Models\Notification;

trait Notifications
{
    public function follower_notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function addNotification(Notifiable $notifiable): self
    {
        if ($this->hasNotification($notifiable)) {
            return $this;
        }

        (new Notification())
            ->user()->associate($this)
            ->notifiable()->associate($notifiable)
            ->save();

        return $this;
    }

    public function removeNotification(Notifiable $notifiable): self
    {
        if (! $this->hasNotification($notifiable)) {
            return $this;
        }

        $notifiable->notifiable()->whereHas('user', fn($q) => $q->whereId($this->id))->delete();

        return $this;
    }

    public function hasNotification(Notifiable $notifiable): bool
    {
        if (! $notifiable->exists) {
            return false;
        }

        return $notifiable->notifiable()->whereHas('user', fn($q) =>  $q->whereId($this->id))->exists();
    }
}
