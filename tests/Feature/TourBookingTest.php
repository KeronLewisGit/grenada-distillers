<?php

namespace Tests\Feature;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Models\Lead;
use App\Models\Setting;
use App\Notifications\LeadReceived;
use App\Notifications\NewLead;
use App\Support\Tours;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TourBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['gdl.notify' => 'tours@example.com', 'gdl.closed_dates' => [], 'gdl.tours.lock_wait' => 1]);
        Notification::fake();
    }

    /** @return array{0: string, 1: string} the first bookable date and time */
    private function slot(int $day = 0): array
    {
        $date = Tours::days()[$day];

        return [$date->toDateString(), Tours::times($date)[0]];
    }

    /** @return array<string, mixed> */
    private function booking(array $overrides = []): array
    {
        [$date, $time] = $this->slot();

        return array_merge($this->contact(), ['slot' => "$date $time", 'adults' => 2, 'children' => 1, 'group_type' => 'family', 'country' => 'United Kingdom'], $overrides);
    }

    public function test_the_tours_page_lists_bookable_slots_with_places_left(): void
    {
        [$date, $time] = $this->slot();
        Setting::put('tour_slot_capacity', '10');
        Lead::factory()->tour($date, $time, 4)->create();

        $this->ofAge()->get('/tours')->assertOk()
            ->assertSee('value="'.$date.' '.$time.'"', false)
            ->assertSee('6 places left');
    }

    public function test_a_booking_gets_a_reference_holds_places_and_emails_both_sides(): void
    {
        $this->post('/tours', $this->booking())->assertRedirect('/thanks');

        $lead = Lead::sole();
        $this->assertMatchesRegularExpression('/^TB-\d{2}-\d{5}$/', $lead->reference);
        $this->assertSame(LeadType::Tour, $lead->type);
        $this->assertSame(3, $lead->guests);
        $this->assertSame(['adults' => 2, 'children' => 1], array_intersect_key($lead->details ?? [], ['adults' => 0, 'children' => 0]));
        [$date, $time] = $this->slot();
        $this->assertSame(Setting::tourCapacity() - 3, Tours::remaining($date, $time));

        $this->ofAge()->get('/thanks')->assertSee($lead->reference);
        Notification::assertSentTo(new AnonymousNotifiable, NewLead::class, fn ($n, $c, $to) => $to->routes['mail'] === ['tours@example.com'] && $n->lead->is($lead));
        Notification::assertSentTo(new AnonymousNotifiable, LeadReceived::class, fn ($n, $c, $to) => $to->routes['mail'] === 'kezia@example.com');
    }

    public function test_a_party_bigger_than_the_places_left_is_refused(): void
    {
        [$date, $time] = $this->slot();
        Setting::put('tour_slot_capacity', '10');
        Lead::factory()->tour($date, $time, 8)->create();

        $this->post('/tours', $this->booking(['adults' => 3, 'children' => 0]))->assertSessionHasErrors(['slot' => 'That tour has only 2 places left. Choose another time or a smaller party.']);
        $this->assertSame(1, Lead::count());

        $this->post('/tours', $this->booking(['adults' => 2, 'children' => 0]))->assertRedirect('/thanks');
        $this->assertSame(0, Tours::remaining($date, $time));
        $this->post('/tours', $this->booking(['adults' => 1, 'children' => 0]))->assertSessionHasErrors(['slot' => 'That tour has just filled up. Please choose another time.']);
    }

    public function test_cancelled_bookings_free_their_places(): void
    {
        [$date, $time] = $this->slot();
        Setting::put('tour_slot_capacity', '4');
        $lead = Lead::factory()->tour($date, $time, 4)->create();
        $this->assertSame(0, Tours::remaining($date, $time));

        $lead->update(['status' => LeadStatus::Cancelled]);
        $this->assertSame(4, Tours::remaining($date, $time));
        $this->post('/tours', $this->booking(['adults' => 4, 'children' => 0]))->assertRedirect('/thanks');
    }

    public function test_capacity_is_claimed_under_a_lock(): void
    {
        [$date, $time] = $this->slot();
        // Another booking for the same slot is mid-way through its check: this one must wait, not slip past.
        $held = Cache::lock('tour-slot:'.$date.' '.$time, 10);
        $this->assertTrue($held->get());

        $this->post('/tours', $this->booking())->assertSessionHasErrors('slot');
        $this->assertSame(0, Lead::count());

        $held->release();
        $this->post('/tours', $this->booking())->assertRedirect('/thanks');
        $this->assertSame(1, Lead::count());
    }

    public function test_other_slots_are_not_blocked_by_the_lock(): void
    {
        [$date, $time] = $this->slot();
        [$date2, $time2] = $this->slot(1);
        Cache::lock('tour-slot:'.$date.' '.$time, 10)->get();

        $this->post('/tours', $this->booking(['slot' => "$date2 $time2"]))->assertRedirect('/thanks');
    }

    public function test_days_without_tours_past_dates_and_odd_times_are_refused(): void
    {
        $sunday = Carbon::parse('next sunday');
        $this->assertSame([], Tours::times($sunday));
        $this->post('/tours', $this->booking(['slot' => $sunday->toDateString().' 10:00']))->assertSessionHasErrors('slot');
        $this->post('/tours', $this->booking(['slot' => today()->toDateString().' '.$this->slot()[1]]))->assertSessionHasErrors('slot');
        $this->post('/tours', $this->booking(['slot' => $this->slot()[0].' 03:15']))->assertSessionHasErrors('slot');
        $this->post('/tours', $this->booking(['slot' => 'tomorrow']))->assertSessionHasErrors('slot');

        $holiday = $this->slot()[0];
        config(['gdl.closed_dates' => [$holiday]]);
        $this->post('/tours', $this->booking(['slot' => $holiday.' '.$this->slot()[1]]))->assertSessionHasErrors('slot');
        $this->assertSame(0, Lead::count());
    }

    public function test_online_parties_are_capped_and_need_an_adult(): void
    {
        Setting::put('tour_max_party', '6');
        $this->post('/tours', $this->booking(['adults' => 7, 'children' => 0]))->assertSessionHasErrors('adults');
        $this->post('/tours', $this->booking(['adults' => 4, 'children' => 3]))->assertSessionHasErrors('adults');
        $this->post('/tours', $this->booking(['adults' => 0, 'children' => 2]))->assertSessionHasErrors('adults');
        $this->assertSame(0, Lead::count());
    }

    public function test_the_honeypot_keeps_nothing(): void
    {
        $this->post('/tours', $this->booking(['website' => 'http://spam.example']))->assertRedirect('/thanks');
        $this->assertSame(0, Lead::count());
        Notification::assertNothingSent();
    }
}
