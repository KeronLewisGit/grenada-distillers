<?php

namespace App\Support;

use App\Models\Lead;
use App\Models\Setting;
use Illuminate\Support\Carbon;

/**
 * Distillery tour slots. Tours run on the weekdays and times in config gdl.tours.slots,
 * never on public holidays (gdl.closed_dates), from tomorrow up to days_ahead.
 * Each slot takes Setting::tourCapacity() guests; cancelled bookings free their places.
 */
final class Tours
{
    /** @return list<Carbon> */
    public static function days(): array
    {
        $out = [];
        $day = today()->addDay();
        $end = today()->addDays((int) config('gdl.tours.days_ahead', 60));
        while ($day->lte($end)) {
            if (self::times($day) !== []) {
                $out[] = $day->copy();
            }
            $day->addDay();
        }

        return $out;
    }

    /**
     * Start times on a day ([] when tours do not run).
     *
     * @return list<string>
     */
    public static function times(Carbon $day): array
    {
        if (in_array($day->toDateString(), (array) config('gdl.closed_dates', []), true)) {
            return [];
        }

        return array_values((array) config('gdl.tours.slots.'.$day->dayOfWeekIso, []));
    }

    /** @return list<string> every start time used on any day, for validation */
    public static function allTimes(): array
    {
        return array_values(array_unique(array_merge(...array_values(array_map('array_values', (array) config('gdl.tours.slots', []))))));
    }

    public static function isBookable(string $date, string $time): bool
    {
        foreach (self::days() as $d) {
            if ($d->toDateString() === $date) {
                return in_array($time, self::times($d), true);
            }
        }

        return false;
    }

    public static function booked(string $date, string $time): int
    {
        return (int) Lead::holdingTourPlaces()->whereDate('visit_date', $date)->where('visit_time', $time)->sum('guests');
    }

    public static function remaining(string $date, string $time): int
    {
        return max(0, Setting::tourCapacity() - self::booked($date, $time));
    }

    /**
     * Every bookable day with the places left in each slot, from one query.
     *
     * @return list<array{date: Carbon, slots: array<string, int>}>
     */
    public static function grid(): array
    {
        $days = self::days();
        if ($days === []) {
            return [];
        }
        $taken = Lead::holdingTourPlaces()
            ->whereBetween('visit_date', [$days[0]->toDateString(), end($days)->toDateString()])
            ->get(['visit_date', 'visit_time', 'guests'])
            ->groupBy(fn (Lead $l) => $l->visit_date?->toDateString().' '.$l->visit_time)
            ->map(fn ($group) => (int) $group->sum('guests'));
        $capacity = Setting::tourCapacity();

        return array_map(fn (Carbon $d) => [
            'date' => $d,
            'slots' => collect(self::times($d))->mapWithKeys(fn (string $t) => [$t => max(0, $capacity - (int) ($taken[$d->toDateString().' '.$t] ?? 0))])->all(),
        ], $days);
    }

    /** 10:00 → 10am, 13:30 → 1:30pm */
    public static function label(string $time): string
    {
        return Hours::time($time);
    }
}
