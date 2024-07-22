<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobCompleted extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $jobDetails;

    public function __construct($jobDetails)
    {
        $this->jobDetails = $jobDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Job Completed')
                    ->view('jobcardmanagement::emails.jobCompleted')->with('jobDetails', $this->jobDetails)
                    ->attach(public_path('pdf/Feedback-Form.docx'));
    }
}
