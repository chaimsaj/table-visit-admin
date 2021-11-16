<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ForgotPasswordEmail
    {
        $subject = 'Forgot Password Email';

        return $this->view('emails.forgot-password')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            // ->cc($address, $name)
            // ->bcc($address, $name)
            // ->replyTo($address, $name)
            ->subject($subject);
        // ->with(['test_message' => $this->data['message']]);

        // return $this->view('view.name');
    }
}
