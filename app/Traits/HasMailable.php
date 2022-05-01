<?php

namespace App\Traits;

use App\Mail\DynamicMail;
use App\Mail\DynamicMailQueued;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\Mail;

trait HasMailable
{
    protected mixed $cc;
    protected mixed $bcc;

    public function __construct()
    {
        $this->cc = null;
        $this->bcc = null;
    }

    public function mail(MailTemplate|string|int $template, array $replaceable): static
    {
        $mailTemplate = new MailTemplate();
        if (is_integer($template)) {
            $mailTemplate = MailTemplate::where('id', $template)->first();
        } else if (is_string($template)) {
            $mailTemplate = MailTemplate::where('code', $template)->first();
        } else if (gettype($template) == MailTemplate::class) {
            $mailTemplate = $template;
        }
        $mailBody = $mailTemplate->content;

        // Replace User Defined Variables
        foreach (array_keys($replaceable) as $key) {
            $mailBody = str_replace($key, $replaceable[$key], $mailBody);
        }

        // Replace default Variables
        $mailBody = str_replace('{nl}', '<br>', $mailBody);
        $mailBody = str_replace('{br}', '<br>', $mailBody);
        $mailBody = str_replace('{app.name}', getSetting('app_name'), $mailBody);
        $mailBody = str_replace('{app.url}', url('/'), $mailBody);

        // Send the mail to provided user
        // With provided mail template
        $mail = Mail::to($this->email)
            ->cc($this->cc)
            ->bcc($this->bcc);

        if ((int)getSetting('mail_queue_enabled')) {
            $mail->send(new DynamicMailQueued($mailTemplate->subject, $mailBody));
        } else {
            $mail->send(new DynamicMail($mailTemplate->subject, $mailBody));
        }

        return $this;
    }



    public function cc(mixed $users): static
    {
        $this->cc = $users;
        return $this;
    }


    public function bcc(mixed $users): static
    {
        $this->bcc = $users;
        return $this;
    }
}
