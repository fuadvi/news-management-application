<?php

namespace App\Listeners;

use App\Events\NewsCreated;
use App\Models\Logging;

class LogNewsCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewsCreated $event): void
    {
        Logging::create([
            'action' => 'create',
            'name' => auth()->user()->name,
            'details' => "News {$event->news->title} has been created",
            'news_id' => $event->news->id,
        ]);
    }
}
