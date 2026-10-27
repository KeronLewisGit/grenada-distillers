<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Setting;
use App\Support\Tours;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

/** Month grid of tour guests against capacity, plus the chosen day's sheet, slot by slot. */
class TourCalendarController extends Controller
{
    public function __invoke(Request $request): View
    {
        $day = self::date(input_string($request->query('day'))) ?? today();
        $month = (self::date(input_string($request->query('month')).'-01') ?? $day)->copy()->startOfMonth();
        $capacity = Setting::tourCapacity();

        $gridStart = $month->copy()->startOfWeek(Carbon::MONDAY);
        $gridEnd = $month->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        $guests = Lead::holdingTourPlaces()->whereBetween('visit_date', [$gridStart->toDateString(), $gridEnd->toDateString()])
            ->get(['visit_date', 'guests'])->groupBy(fn (Lead $l) => $l->visit_date?->toDateString())->map(fn ($g) => (int) $g->sum('guests'));

        $weeks = [];
        for ($d = $gridStart->copy(); $d->lte($gridEnd); $d->addDay()) {
            $slots = count(Tours::times($d));
            $weeks[intdiv((int) $gridStart->diffInDays($d), 7)][] = [
                'date' => $d->copy(),
                'guests' => (int) ($guests[$d->toDateString()] ?? 0),
                'places' => $slots * $capacity,
                'open' => $slots > 0,
            ];
        }

        $bookings = Lead::where('type', LeadType::Tour)->whereDate('visit_date', $day)->with('assignee')->orderBy('visit_time')->orderBy('id')->get();
        $sheet = collect(Tours::times($day))->merge($bookings->pluck('visit_time')->filter())->unique()->sort()->values()
            ->map(fn (string $t) => [
                'time' => $t,
                'bookings' => $bookings->where('visit_time', $t)->values(),
                'guests' => (int) $bookings->where('visit_time', $t)->where('status', '!=', LeadStatus::Cancelled)->sum('guests'),
            ]);

        return view('admin.tours.index', [
            'month' => $month,
            'weeks' => $weeks,
            'capacity' => $capacity,
            'day' => $day,
            'sheet' => $sheet,
        ]);
    }

    /** A real Y-m-d date, or null: 2026-13-45 and 2026-02-30 are refused rather than rolled over. */
    private static function date(string $value): ?Carbon
    {
        if (! preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $m) || ! checkdate((int) $m[2], (int) $m[3], (int) $m[1])) {
            return null;
        }

        return Carbon::createFromFormat('!Y-m-d', $value) ?: null;
    }
}
