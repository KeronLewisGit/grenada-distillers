<?php

namespace App\Notifications;

use App\Enums\LeadType;
use App\Models\Lead;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** To the office: a new request to answer. CVs stay in the back office, never in email. */
class NewLead extends Notification
{
    public function __construct(public readonly Lead $lead) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $l = $this->lead;
        $mail = (new MailMessage)
            ->subject("{$l->type->label()} {$l->reference}: {$l->name}")
            ->line($l->name.($l->organisation ? " ({$l->organisation})" : '').($l->phone ? ' · '.format_phone($l->phone) : '')." · {$l->email}");

        if ($subject = $l->subject()) {
            $mail->line($subject);
        }
        if ($l->type === LeadType::Application) {
            $mail->line('The CV is in the back office.');
        } elseif ($l->message) {
            $mail->line($l->message);
        }

        $mail->line('Please reply within one working day.')
            ->action('Open the request', route('admin.leads.show', $l));

        if ($l->type !== LeadType::Application) {
            $mail->replyTo($l->email, $l->name);
        }

        return $mail;
    }
}
