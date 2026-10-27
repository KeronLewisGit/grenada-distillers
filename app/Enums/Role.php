<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Tours = 'tours';
    case Trade = 'trade';
    case Hr = 'hr';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Tours => 'Tours & visitor centre',
            self::Trade => 'Trade & export',
            self::Hr => 'Human resources',
        };
    }

    /**
     * Request types this role works in the inbox. Job applications (and CVs) are HR's and admins' only.
     *
     * @return list<LeadType>
     */
    public function leadTypes(): array
    {
        return match ($this) {
            self::Admin => LeadType::cases(),
            self::Tours => [LeadType::Tour, LeadType::Enquiry],
            self::Trade => [LeadType::Trade, LeadType::Enquiry],
            self::Hr => [LeadType::Application],
        };
    }
}
