<?php

namespace App\Events;

use App\Model\Form;
use App\Model\Reply;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FormReplied implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Form $form;
    public Reply $reply;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Form $form, Reply $reply)
    {
        $this->form = $form->withoutRelations();
        $this->reply = $reply->withoutRelations();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('forms.'.$this->form->id);
    }
}
