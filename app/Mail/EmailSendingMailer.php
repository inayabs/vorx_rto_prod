<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSendingMailer extends Mailable
{
    use Queueable, SerializesModels;

    // protected $mailer_body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct($mail_body)
    public function __construct()
    {
        //
        // $this->mailer_body = $mail_body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('email-sending.send')->with([
        //     'mailBody' => $this->mailer_body,
        // ]);;
        // return $this->view('email-sending.send');
    }
}
