<?php

namespace App\Enums;

enum LeadType: string
{
    case Tour = 'tour';
    case Trade = 'trade';
    case Application = 'application';
    case Enquiry = 'enquiry';

    public function label(): string
    {
        return match ($this) {
            self::Tour => 'Tour booking',
            self::Trade => 'Trade enquiry',
            self::Application => 'Job application',
            self::Enquiry => 'Enquiry',
        };
    }

    /** Two-letter prefix of the public reference, e.g. TB-26-00042. */
    public function prefix(): string
    {
        return match ($this) {
            self::Tour => 'TB',
            self::Trade => 'TE',
            self::Application => 'JA',
            self::Enquiry => 'EN',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Tour => 'ticket',
            self::Trade => 'ship',
            self::Application => 'briefcase',
            self::Enquiry => 'message',
        };
    }

    /**
     * The statuses this kind of request moves through, in order.
     *
     * @return list<LeadStatus>
     */
    public function statuses(): array
    {
        return match ($this) {
            self::Tour => [LeadStatus::New, LeadStatus::Confirmed, LeadStatus::Attended, LeadStatus::NoShow, LeadStatus::Cancelled],
            self::Trade => [LeadStatus::New, LeadStatus::Contacted, LeadStatus::Qualified, LeadStatus::Samples, LeadStatus::Signed, LeadStatus::Declined],
            self::Application => [LeadStatus::New, LeadStatus::Reviewing, LeadStatus::Interview, LeadStatus::Offered, LeadStatus::Hired, LeadStatus::Declined],
            self::Enquiry => [LeadStatus::New, LeadStatus::Replied, LeadStatus::Closed],
        };
    }

    /** Where a new request moves when staff log their first reply. */
    public function firstReplyStatus(): LeadStatus
    {
        return match ($this) {
            self::Tour => LeadStatus::Confirmed,
            self::Trade => LeadStatus::Contacted,
            self::Application => LeadStatus::Reviewing,
            self::Enquiry => LeadStatus::Replied,
        };
    }
}
