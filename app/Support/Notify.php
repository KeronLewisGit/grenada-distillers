<?php

namespace App\Support;

use App\Enums\LeadType;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

use function Illuminate\Support\defer;

/**
 * Emails the team that handles the request and confirms to the customer. Mail goes out after the response
 * is sent, so a slow or failing mail server never makes a customer wait or lose a submission.
 */
final class Notify
{
    /**
     * Valid addresses for a request type: its team inbox (gdl.notify_teams) when one is set,
     * otherwise the general list (gdl.notify). Without a type: the general list.
     *
     * @return list<string>
     */
    public static function recipients(?LeadType $type = null): array
    {
        return self::valid(self::configured($type));
    }

    /** True when at least one inbox (general or team) is set up. */
    public static function anyRecipients(): bool
    {
        return self::valid(self::everything()) !== [];
    }

    /**
     * Entries in GDL_NOTIFY_* that are not email addresses (typos), shown on the dashboard.
     *
     * @return list<string>
     */
    public static function invalid(): array
    {
        $all = self::everything();

        return array_values(array_unique(array_diff($all, self::valid($all))));
    }

    /**
     * @param  list<string>  $list
     * @return list<string>
     */
    private static function valid(array $list): array
    {
        return array_values(array_filter($list, fn (string $a) => (bool) filter_var($a, FILTER_VALIDATE_EMAIL)));
    }

    /** @return list<string> */
    private static function split(mixed $value): array
    {
        return preg_split('/[\s,;]+/', is_string($value) ? $value : '', -1, PREG_SPLIT_NO_EMPTY) ?: [];
    }

    /** @return list<string> */
    private static function configured(?LeadType $type): array
    {
        $team = $type ? self::split(config('gdl.notify_teams.'.$type->value)) : [];

        return $team !== [] ? $team : self::split(config('gdl.notify'));
    }

    /** @return list<string> */
    private static function everything(): array
    {
        $all = self::split(config('gdl.notify'));
        foreach ((array) config('gdl.notify_teams', []) as $list) {
            $all = array_merge($all, self::split($list));
        }

        return $all;
    }

    /** Emails the team that handles a request type (or the general list), after the response is sent. */
    public static function office(BaseNotification $notification, ?LeadType $type = null): void
    {
        $to = self::recipients($type);

        if ($to === []) {
            Log::warning('No GDL_NOTIFY_* inbox is set for this request; nobody was emailed about it.', ['notification' => $notification::class, 'type' => $type?->value]);

            return;
        }

        if ($skipped = array_values(array_diff(self::configured($type), $to))) {
            Log::warning('GDL_NOTIFY_* has entries that are not email addresses; they were skipped.', ['skipped' => $skipped]);
        }

        defer(function () use ($to, $notification): void {
            try {
                Notification::route('mail', $to)->notify($notification);
            } catch (Throwable $e) {
                report($e);
            }
        });
    }

    /** Confirmation to the customer, when they gave a usable email address. */
    public static function customer(?string $email, BaseNotification $notification): void
    {
        if (! $email || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        defer(function () use ($email, $notification): void {
            try {
                Notification::route('mail', $email)->notify($notification);
            } catch (Throwable $e) {
                report($e);
            }
        });
    }
}
