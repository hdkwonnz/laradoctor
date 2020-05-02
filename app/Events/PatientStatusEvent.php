<?php

namespace App\Events;

use App\Appointment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PatientStatusEvent implements ShouldBroadcast ////
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointment;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('patient-status');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        // foreach ($this->appointments as $this->appointment) {
        //     $extra = [
        //         'patient_name' => $this->appointment->patient->name,  
        //     ];
        // }
        
        $extra = [
            'patient_name' => $this->appointment->patient->name,  
        ];
        return array_merge($this->appointment->toArray(), $extra);
    }
}
