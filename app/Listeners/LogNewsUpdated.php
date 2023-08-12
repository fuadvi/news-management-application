<?php

namespace App\Listeners;

use App\Events\NewsUpdated;
use App\Models\Logging;

class LogNewsUpdated
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
    public function handle(NewsUpdated $event): void
    {
        Logging::create([
            'action' => 'update',
            'name' => auth()->user()->name,
            'details' =>"News {$event->news->title} has been updated",
            'news_id' => $event->news->id,
        ]);
    }
}
