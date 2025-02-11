<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $data;

    /**
     * Create a new event instance.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * กำหนดช่องที่ Event นี้จะถูกส่งไป
     */
    public function broadcastOn()
    {
        return new Channel('my-channel'); // เปลี่ยนให้ตรงกับ Pusher
    }

    /**
     * กำหนดชื่อ Event ที่จะใช้ใน Frontend
     */
    public function broadcastAs()
    {
        return 'my-event'; // เปลี่ยนให้ตรงกับ JavaScript
    }

    /**
     * ข้อมูลที่จะถูกส่งไปยัง Frontend
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->data,
            'time' => now()->diffForHumans()
        ];
    }
}
