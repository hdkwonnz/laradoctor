<?php

namespace App\Listeners;

use App\Events\AppointmentStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentStatusListener
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
     * @param  AppointmentStatus  $event
     * @return void
     */
    public function handle(AppointmentStatus $event)
    {
        //
    }
}
