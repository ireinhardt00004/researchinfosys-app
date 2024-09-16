<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyToContactUs extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;

    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    public function build()
    {
        return $this->view('emails.reply_to_contact_us')
                    ->subject('Reply to Your Concern')
                    ->with([
                        'reply' => $this->reply,
                    ]);
    }
}

