<?php

namespace App\Enums;

/**
 * Every status any request can be in. Each LeadType uses its own subset (LeadType::statuses()).
 * Colour is never the only signal: each status has an icon and text.
 */
enum LeadStatus: string
{
    case New = 'new';
    // tours
    case Confirmed = 'confirmed';
    case Attended = 'attended';
    case NoShow = 'no_show';
    case Cancelled = 'cancelled';
    // trade
    case Contacted = 'contacted';
    case Qualified = 'qualified';
    case Samples = 'samples';
    case Signed = 'signed';
    // applications
    case Reviewing = 'reviewing';
    case Interview = 'interview';
    case Offered = 'offered';
    case Hired = 'hired';
    // shared endings
    case Declined = 'declined';
    case Replied = 'replied';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::New => 'New',
            self::Confirmed => 'Confirmed',
            self::Attended => 'Attended',
            self::NoShow => 'No-show',
            self::Cancelled => 'Cancelled',
            self::Contacted => 'Contacted',
            self::Qualified => 'Qualified',
            self::Samples => 'Samples sent',
            self::Signed => 'Distributor signed',
            self::Reviewing => 'Reviewing',
            self::Interview => 'Interview',
            self::Offered => 'Offer made',
            self::Hired => 'Hired',
            self::Declined => 'Declined',
            self::Replied => 'Replied',
            self::Closed => 'Closed',
        };
    }

    public function tone(): string
    {
        return match ($this) {
            self::New => 'attention',
            self::Attended, self::Signed, self::Hired, self::Replied => 'good',
            self::Cancelled, self::NoShow, self::Declined, self::Closed => 'muted',
            default => 'neutral',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::New => 'dot',
            self::Confirmed, self::Qualified => 'check',
            self::Attended, self::Signed, self::Hired, self::Replied => 'check-circle',
            self::NoShow, self::Cancelled, self::Declined, self::Closed => 'x',
            self::Contacted => 'phone',
            self::Samples => 'package',
            self::Reviewing => 'eye',
            self::Interview => 'calendar',
            self::Offered => 'mail',
        };
    }

    /** Finished: nothing left for staff to do. */
    public function isClosed(): bool
    {
        return in_array($this, self::closed(), true);
    }

    /** @return list<self> */
    public static function closed(): array
    {
        return [self::Attended, self::NoShow, self::Cancelled, self::Signed, self::Hired, self::Declined, self::Closed];
    }
}
