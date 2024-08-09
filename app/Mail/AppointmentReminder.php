<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointments;
use App\Models\User;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $user;
    public $remainingDaysMessage;

    public function __construct(Appointments $appointment, User $user, $remainingDaysMessage)
    {
        $this->appointment = $appointment;
        $this->user = $user;
        $this->remainingDaysMessage = $remainingDaysMessage;
    }

    public function build()
    {
        return $this->view('emails.appointment_reminder')
                    ->subject('Appointment Reminder')
                    ->with([
                        'appointment' => $this->appointment,
                        'user' => $this->user,
                        'remainingDaysMessage' => $this->remainingDaysMessage,
                    ]);
    }
}
