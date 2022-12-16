<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SavedReservations implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $saved_reservation;
    public $user_id;
    public $status;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($saved_reservation, $user_id, $status)
    {
      $this->saved_reservation = $saved_reservation;
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

    // public function broadcastWith()
    // {
    //   $this->saved_reservation->load('usermodel', 'usercontactmodel');
    // 
    //   return ["saved_reservation" => $this->reservation, "user_id" => $this->user_id, "status" => $this->status];
    // }
}
