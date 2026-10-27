<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Models\Lead;
use App\Models\Setting;
use App\Models\User;
use App\Support\Notify;
use App\Support\Tours;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const int CHART_DAYS = 30;

    public function __invoke(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();
        $mine = fn () => Lead::visibleTo($user);
        $chartStart = today()->subDays(self::CHART_DAYS - 1);

        // The one number: requests nobody has answered within a working day.
        $overdue = $mine()->overdue();
        $oldest = (clone $overdue)->min('created_at');

        $dates = $mine()->where('created_at', '>=', $chartStart)->pluck('created_at')->countBy(fn (Carbon $d) => $d->toDateString());
        $daily = collect(range(0, self::CHART_DAYS - 1))->map(function (int $i) use ($chartStart, $dates) {
            $day = $chartStart->copy()->addDays($i);

            return ['date' => $day, 'count' => (int) ($dates[$day->toDateString()] ?? 0)];
        });

        // Median hours from arrival to first reply over the last 30 days.
        $responses = $mine()->whereNotNull('first_contacted_at')->where('created_at', '>=', now()->subDays(30))->get(['created_at', 'first_contacted_at'])
            ->map(fn (Lead $l) => (int) $l->created_at->diffInMinutes($l->first_contacted_at))->sort()->values();
        $median = $responses->isEmpty() ? null : (int) $responses->median();

        $tiles = [
            ['label' => 'New requests, last 7 days', 'value' => $mine()->where('created_at', '>=', now()->subDays(7))->count(),
                'previous' => $mine()->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count(), 'period' => 'vs previous 7 days',
                'href' => route('admin.leads.index')],
            ['label' => 'Median time to first reply', 'value' => $median, 'format' => 'minutes', 'note' => 'last 30 days, '.$responses->count().' requests', 'href' => route('admin.leads.index')],
        ];
        if ($user->canWork(LeadType::Tour)) {
            $week = Lead::holdingTourPlaces()->whereBetween('visit_date', [today()->toDateString(), today()->addDays(6)->toDateString()]);
            $tiles[] = ['label' => 'Guests booked, next 7 days', 'value' => (int) (clone $week)->sum('guests'),
                'note' => (clone $week)->count().' bookings', 'href' => route('admin.tours.index')];
            $todayGuests = (int) Lead::holdingTourPlaces()->whereDate('visit_date', today())->sum('guests');
            $todaySlots = count(Tours::times(today()));
            $tiles[] = ['label' => 'Guests on today\'s tours', 'value' => $todayGuests,
                'note' => $todaySlots ? 'of '.($todaySlots * Setting::tourCapacity()).' places in '.$todaySlots.' tours' : 'no tours today', 'href' => route('admin.tours.index', ['day' => today()->toDateString()])];
        }
        if ($user->canWork(LeadType::Trade)) {
            $tiles[] = ['label' => 'Open trade enquiries', 'value' => Lead::where('type', LeadType::Trade)->whereNotIn('status', LeadStatus::closed())->count(),
                'note' => Lead::where('type', LeadType::Trade)->where('created_at', '>=', now()->subDays(90))->distinct()->count('country').' countries in 90 days', 'href' => route('admin.leads.index', ['type' => 'trade', 'status' => 'open'])];
        }
        if ($user->hasRole(Role::Admin, Role::Hr)) {
            $tiles[] = ['label' => 'Applications to review', 'value' => Lead::where('type', LeadType::Application)->whereIn('status', [LeadStatus::New, LeadStatus::Reviewing])->count(),
                'note' => JobPosting::open()->count().' vacancies open', 'href' => route('admin.leads.index', ['type' => 'application', 'status' => 'open'])];
        }

        return view('admin.dashboard', [
            'overdueCount' => $overdue->count(),
            'oldestOverdue' => $oldest ? Carbon::parse($oldest) : null,
            'newCount' => $mine()->where('status', LeadStatus::New)->count(),
            'tiles' => $tiles,
            'daily' => $daily,
            'dailyMax' => max(1, (int) $daily->max('count')),
            'chartDays' => self::CHART_DAYS,
            'byType' => collect($user->role->leadTypes())->map(fn (LeadType $t) => [
                'type' => $t, 'count' => $mine()->where('type', $t)->where('created_at', '>=', $chartStart)->count(),
            ])->sortByDesc('count')->values(),
            'queue' => $mine()->with('jobPosting')->where('status', LeadStatus::New)->oldest()->limit(8)->get(),
            'upcoming' => $user->canWork(LeadType::Tour)
                ? Lead::holdingTourPlaces()->where('status', '!=', LeadStatus::NoShow)->whereBetween('visit_date', [today()->toDateString(), today()->addDays(2)->toDateString()])
                    ->orderBy('visit_date')->orderBy('visit_time')->limit(8)->get()
                : collect(),
            'notifyMissing' => $user->isAdmin() && Notify::recipients() === [],
            'notifyInvalid' => $user->isAdmin() ? Notify::invalid() : [],
        ]);
    }
}
