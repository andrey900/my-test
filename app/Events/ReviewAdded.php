<?php

namespace App\Events;

use App\Models\Review;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The review instance
     *
     * @var \App\Models\Review
     */
    public $review;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\PresenceChannel
     */
    public function broadcastOn()
    {
        return new PresenceChannel('reviews');
    }
}
