<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment; //from AppointmentController
    public $doctorName;//from AppointmentController
    public $patientName;//from AppointmentController

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment,$doctorName,$patientName)
    {
        $this->appointment = $appointment;
        $this->doctorName = $doctorName;
        $this->patientName = $patientName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('예약 내용')
                    ->view('emails.appointmentDetails');
    }
}
