<?php

namespace App\Events;

use App\Models\Notification as NotificationModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    public function __construct(NotificationModel $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('notifications.' . $this->notification->user_id);
    }

    public function broadcastAs()
    {
        return 'new-notification';
    }

    public function broadcastWith()
    {
        return [
            'id'       => $this->notification->id,
            'title'    => $this->notification->title,
            'message'  => $this->notification->message,
            'time'     => $this->notification->created_at->diffForHumans(),
            'icon'     => $this->notification->icon ?? 'feather icon-bell',
            'color'    => $this->notification->color ?? 'text-primary',
            'link'     => $this->notification->link ?? '#',
        ];
    }
}