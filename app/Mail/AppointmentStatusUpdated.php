<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointments;
use App\Models\User;

class AppointmentStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Appointments $appointment, User $user)
    {
        $this->appointment = $appointment;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.appointment_status_updated')
                    ->subject('Your Appointment Status Has Been Updated')
                    ->with([
                        'appointment' => $this->appointment,
                        'user' => $this->user,
                    ]);
    }
}
