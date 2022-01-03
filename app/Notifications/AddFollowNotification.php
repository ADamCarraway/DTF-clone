<?php

namespace App\Notifications;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AddFollowNotification extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var User
     */
    private User $user;

    /**
     * AddFollowNotification constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        $this->onQueue('notification');

        return $notifiable->isNotificationEnabled(self::class) ? ['broadcast', 'database'] : [];
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return new BroadcastMessage([
            'user' => $this->user,
            'date' => now()->locale('ru')->calendar(),
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'read_at' => null,
            'data'    => [
                'user' => $this->user,
                'date' => now()->calendar(),
            ],
        ]);
    }
}
