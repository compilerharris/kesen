<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WriterPayment extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $job_card;
    public $paymentDetails;
    public $writer;

    public function __construct($job_card, $paymentDetails, $writer)
    {
        $this->$job_card = $job_card;
        $this->paymentDetails = $paymentDetails;
        $this->writer = $writer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Payment Advice')
                    ->view('writermanagement::emails.payment')
                    ->with('job_card',$this->job_card)
                    ->with('writer_payment', $this->paymentDetails)
                    ->with('writer', $this->writer);
    }
}
