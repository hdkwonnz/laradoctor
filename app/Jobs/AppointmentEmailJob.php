<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\AppointmentEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AppointmentEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $appointment; //from AppointmentController
    protected $patientName;//from AppointmentController
    protected $doctorName;//from AppointmentController
    protected $patientEmail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($appointment,$patientName,$doctorName,$patientEmail)
    {
        $this->appointment = $appointment;
        $this->patientName = $patientName;
        $this->doctorName = $doctorName;
        $this->patientEmail = $patientEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->patientEmail)->send(new AppointmentEmail($this->appointment,$this->doctorName,$this->patientName));
    }
}
