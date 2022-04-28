<?php

namespace App\Traits;

use App\Mail\DynamicMail;
use Devsbuddy\AdminrEngine\Models\MailTemplate;
use Illuminate\Support\Facades\Mail;

trait CanSendMail
{

    public function sendMailTo($email, $template, array $replaceable): static
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
        if (is_array($email)) {
            foreach ($email as $e) {
                Mail::to($e)->send(new DynamicMail($mailTemplate->subject, $mailBody));
            }
        } else {
            Mail::to($email)->send(new DynamicMail($mailTemplate->subject, $mailBody));
        }

        return $this;
    }
}
