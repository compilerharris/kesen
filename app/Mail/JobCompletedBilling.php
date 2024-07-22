<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobCompletedBilling extends Mailable
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
                    ->view('jobcardmanagement::emails.jobCompletedBilling')->with('jobDetails', $this->jobDetails);
    }
}
