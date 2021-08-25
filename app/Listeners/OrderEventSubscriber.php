<?php

namespace App\Listeners;

use App\Events\OrderCommented;
use App\Events\OrderCompleted;
use App\Events\OrderCreated;
use App\Jobs\ProcessCommentGithubIssue;
use App\Model\Feedback;
use App\Model\OrderEvaluation;
use App\Notifications\OrderCommented as OrderCommentedNotification;
use App\Notifications\OrderCompleted as OrderCompletedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderEventSubscriber
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  OrderChanged  $event
     * @return void
     */
    public function handleOrderCommented(OrderCommented $event)
    {
    }

    /**
     * Handle the event.
     *
     * @param  OrderCompleated  $event
     * @return void
     */
    public function handleOrderCompleted(OrderCompleted $event)
    {
    }    

    /**
     * Handle the event.
     *
     * @param  OrderCompleated  $event
     * @return void
     */
    public function handleOrderCreated(OrderCreated $event)
    {
    }        

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            OrderCommented::class,
            [OrderEventSubscriber::class, 'handleOrderCommented']
        );

        $events->listen(
            OrderCompleted::class,
            [OrderEventSubscriber::class, 'handleOrderCompleted']
        );

        $events->listen(
            OrderCreated::class,
            [OrderEventSubscriber::class, 'handleOrderCreated']
        );        
    }
}
