<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMailQueued extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct()
    {

    }

    public function build(): static
    {
        return $this->subject('This is a test mail with Queue')
            ->markdown('emails.test-mail');
    }
}
