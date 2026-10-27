<?php

namespace App\Notifications;

use App\Enums\LeadType;
use App\Models\Lead;
use App\Support\Hours;
use App\Support\Tours;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** To the visitor, buyer or applicant: we have it, here is the reference, here is what happens next. */
class LeadReceived extends Notification
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
            ->subject("Clarke's Court: your {$this->what()} ({$l->reference})")
            ->greeting('Thank you, '.strtok($l->name, ' ').'.')
            ->line("We have your {$this->what()}. Your reference is **{$l->reference}**.");

        if ($l->type === LeadType::Tour && $l->visit_date) {
            $mail->line('Tour: '.$l->visit_date->format('l j F Y').' at '.Tours::label((string) $l->visit_time).', '.$l->guests.' '.($l->guests === 1 ? 'guest' : 'guests').'.')
                ->line('Your places are held. We will email to confirm, and if you need to change or cancel, reply to this email with your reference.')
                ->line('Tastings are for guests aged '.gdl('legal_age').' and over; photo ID may be asked for.');
        }
        if ($l->type === LeadType::Application) {
            $mail->line('Applying for: '.($l->jobPosting->title ?? 'a general application').'.');
        }

        $mail->line(match ($l->type) {
            LeadType::Tour => 'Directions: '.gdl('address.street').', '.gdl('address.locality').', '.gdl('address.parish').'.',
            LeadType::Trade => 'Our export team will read your enquiry and reply by email, usually within two working days.',
            LeadType::Application => 'Our HR team reviews every application. If you are shortlisted we will contact you to arrange an interview. We keep applications for 12 months.',
            LeadType::Enquiry => 'A member of our team will reply during office hours.',
        });

        return $mail
            ->line('Office hours: '.Hours::summary().'. Telephone '.format_phone((string) gdl('phone')).'.')
            ->salutation(gdl('name').', '.gdl('address.locality').', '.gdl('address.parish').', Grenada');
    }

    private function what(): string
    {
        return match ($this->lead->type) {
            LeadType::Tour => 'distillery tour booking',
            LeadType::Trade => 'trade enquiry',
            LeadType::Application => 'job application',
            LeadType::Enquiry => 'message',
        };
    }
}
