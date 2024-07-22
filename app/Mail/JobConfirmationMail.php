<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobRegister;

    /**
     * Create a new message instance.
     */
    public function __construct($jobRegister)
    {
        $this->jobRegister = $jobRegister;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Job Confirmation Letter')
                    ->view('jobregistermanagement::job-register-complete-pdf')
                    ->with('jobRegister', $this->jobRegister);
    }

}
