<?php

namespace App\Traits;

use App\Mail\DynamicMail;
use App\Mail\DynamicMailQueued;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\Mail;

trait CanSendMail
{
    protected mixed $cc;
    protected mixed $bcc;

    public function __construct()
    {
        $this->cc = null;
        $this->bcc = null;
    }


    /**
     * Helps to send email from templates easily
     *
     * @param array|string $emails
     * You can pass user's email as string
     * or array of emails.
     *
     * @param MailTemplate|string|int $template
     * $template is the [MailTemplate] object itself or
     * you can pass it's id or code
     *
     * @param array $replaceable
     * Replaceable is the array of variables and their values
     * which is already defined in the template content
     *
     * @return static
     */
    public function sendMailTo(array|string $emails, MailTemplate|string|int $template, array $replaceable): static
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

        // Send the mail to provided email
        if (is_array($emails)) {
            foreach ($emails as $e) {
                $mail = Mail::to($e)
                    ->cc($this->cc)
                    ->bcc($this->bcc);

                if ((int)getSetting('mail_queue_enabled')) {
                    $mail->send(new DynamicMailQueued($mailTemplate->subject, $mailBody));
                } else {
                    $mail->send(new DynamicMail($mailTemplate->subject, $mailBody));
                }
            }
        } else {
            $mail = Mail::to($emails)
                ->cc($this->cc)
                ->bcc($this->bcc);

            if ((int)getSetting('mail_queue')) {
                $mail->send(new DynamicMailQueued($mailTemplate->subject, $mailBody));
            } else {
                $mail->send(new DynamicMail($mailTemplate->subject, $mailBody));
            }
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
