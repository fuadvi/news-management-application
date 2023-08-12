<?php

namespace App\Listeners;

use App\Events\NewsDeleted;
use App\Models\Logging;

class LogNewsDeleted
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
    public function handle(NewsDeleted $event): void
    {
        Logging::create([
            'action' => 'delete',
            'name' => auth()->user()->name,
            'details' => "News {$event->news->title} has been deleted",
            'news_id' => $event->news->id,
        ]);
    }
}
