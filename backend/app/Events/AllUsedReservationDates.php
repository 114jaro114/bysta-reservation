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

class AllUsedReservationDates implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reservations_dates;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($reservations_dates)
    {
      $this->reservations_dates = $reservations_dates;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('reservations_dates');
    }

    // public function broadcastWith()
    // {
    //     $this->friendship->load('fromUser');
    //
    //     return ["friendship" => $this->friendship];
    // }
}
