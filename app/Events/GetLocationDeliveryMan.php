<?php

namespace CodeDelivery\Events;

use CodeDelivery\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use CodeDelivery\Models\Geo;
use CodeDelivery\Models\Order;

class GetLocationDeliveryman extends Event implements ShouldBroadcast
{
    use SerializesModels;
    
    public $geo;
    
    private $modelO;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Geo $geo, Order $order)
    {
        $this->geo = $geo;
        $this->modelO = $order;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [$this->modelO->hash];
    }
}