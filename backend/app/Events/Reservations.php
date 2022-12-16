<?php

namespace App\Events;

// use App\Models\Reservation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Reservations implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reservation;
    public $user_id;
    public $status;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($reservation, $user_id, $status)
    {
      $this->reservation = $reservation;
      $this->user_id = $user_id;
      $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('reservation.' . $this->user_id);
    }

    public function broadcastWith()
    {
      $this->reservation->load('usermodel', 'usercontactmodel');

      return ["reservation" => $this->reservation, "user_id" => $this->user_id, "status" => $this->status];
    }
}
