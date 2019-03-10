<?php

namespace App\Listeners;

use App\Events\FileWritten;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlotGraph
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FileWritten  $event
     * @return void
     */
    public function handle(FileWritten $event)
    {
        //
    }
}
