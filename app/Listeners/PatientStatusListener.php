<?php

namespace App\Listeners;

use App\Events\PatientStatusEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PatientStatusListener
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
     * @param  PatientStatusEvent  $event
     * @return void
     */
    public function handle(PatientStatusEvent $event)
    {
        //
    }
}
