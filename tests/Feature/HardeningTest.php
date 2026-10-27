<?php

namespace Tests\Feature;

use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Enums\Role;
use App\Http\Middleware\AgeGate;
use App\Models\Lead;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\NewLead;
use App\Support\Notify;
use App\Support\Tours;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/** Regression tests for the issues found in the pre-pitch review. */
class HardeningTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['gdl.closed_dates' => [], 'gdl.tours.lock_wait' => 1]);
        Notification::fake();
        Storage::fake('local');
    }

    /** @return array{0: string, 1: string} */
    private function slot(): array
    {
        $date = Tours::days()[0];

        return [$date->toDateString(), Tours::times($date)[0]];
    }

    /**
     * A tampered form (fields sent as arrays, or a slot that is not a date) used to crash the page it
     * was sent back to with a 500, because the old input was printed as a string or parsed as a date.
     *
     * @return array<string, array{0: string, 1: array<string, mixed>}>
     */
    public static function tamperedForms(): array
    {
        return [
            'tours, slot not a date' => ['/tours', ['slot' => 'garbage', 'adults' => 1]],
            'tours, impossible date' => ['/tours', ['slot' => '2026-99-99 10:00', 'adults' => 1]],
            'tours, arrays' => ['/tours', ['slot' => ['x'], 'adults' => ['1'], 'name' => ['a'], 'group_type' => ['x']]],
            'trade, arrays' => ['/trade', ['organisation' => ['x'], 'business_type' => ['x'], 'message' => ['x'], 'products' => 'abc']],
            'contact, arrays' => ['/contact', ['topic' => ['x'], 'email' => ['a'], 'message' => ['m']]],
            'apply, arrays' => ['/careers/apply', ['job' => ['x'], 'parish' => ['x'], 'available_from' => ['x']]],
        ];
    }

    /** @param array<string, mixed> $fields */
    #[DataProvider('tamperedForms')]
    public function test_a_tampered_form_comes_back_with_errors_not_a_server_error(string $path, array $fields): void
    {
        $this->ofAge()->from($path)->post($path, $fields)->assertRedirect($path)->assertSessionHasErrors();
        $this->ofAge()->get($path)->assertOk();
    }

    public function test_the_sign_in_page_survives_a_tampered_email(): void
    {
        $this->from('/login')->post('/login', ['email' => ['x'], 'password' => 'p'])->assertRedirect('/login');
        $this->get('/login')->assertOk();
    }

    public function test_a_contact_topic_sent_as_an_array_is_ignored(): void
    {
        $this->ofAge()->get('/contact?topic[]=tour_group')->assertOk()->assertSee('<option value="general" selected', false);
        $this->ofAge()->get('/contact?topic=tour_group')->assertOk()->assertSee('<option value="tour_group" selected', false);
    }

    public function test_the_age_check_refuses_control_characters_in_the_return_path(): void
    {
        $this->assertSame('/', AgeGate::safeNext("/\n/evil.example"));
        $this->assertSame('/', AgeGate::safeNext("/\t/evil.example"));
        $this->assertSame('/rums?family=aged', AgeGate::safeNext('/rums?family=aged'));
        $this->post('/age', ['answer' => 'yes', 'next' => "/\r\nSet-Cookie: x=1"])->assertRedirect('/');
    }

    public function test_tours_run_on_grenada_time(): void
    {
        $this->assertSame('America/Grenada', config('app.timezone'));
    }

    public function test_a_long_phone_number_fits_the_search_column(): void
    {
        // MySQL in strict mode refuses a value longer than the column; SQLite has no lengths, so check the migration.
        $lead = Lead::factory()->create(['phone' => str_repeat('1', 30)]);
        $this->assertSame(str_repeat('1', 30), $lead->fresh()?->getAttribute('phone_digits'));
        $this->assertGreaterThanOrEqual(30, $this->columnLength('phone_digits'));
    }

    public function test_a_staff_email_differing_only_in_case_is_a_duplicate_not_a_server_error(): void
    {
        $admin = $this->staff(Role::Admin);
        User::factory()->role(Role::Tours)->create(['email' => 'guide@clarkescourt.test']);

        $this->actingAs($admin)->from('/admin/users')->post('/admin/users', ['name' => 'Guide', 'email' => 'GUIDE@clarkescourt.test', 'role' => 'tours', 'password' => 'long-enough-1'])
            ->assertRedirect('/admin/users')->assertSessionHasErrors('email');
        $this->assertSame(1, User::where('email', 'guide@clarkescourt.test')->count());
    }

    public function test_a_refused_assignment_leaves_the_status_and_timeline_unchanged(): void
    {
        $admin = $this->staff(Role::Admin);
        $hr = $this->staff(Role::Hr);
        $lead = Lead::factory()->trade()->create();

        $this->actingAs($admin)->patch("/admin/requests/{$lead->id}", ['status' => 'contacted', 'assigned_to' => $hr->id])
            ->assertSessionHasErrors('assigned_to');

        $lead->refresh();
        $this->assertSame(LeadStatus::New, $lead->status);
        $this->assertSame(0, $lead->notes()->count());
    }

    public function test_a_cancelled_booking_cannot_be_put_back_on_a_tour_that_has_since_filled(): void
    {
        [$date, $time] = $this->slot();
        Setting::put('tour_slot_capacity', '10');
        $cancelled = Lead::factory()->tour($date, $time, 4)->create(['status' => LeadStatus::Cancelled]);
        Lead::factory()->tour($date, $time, 8)->create();
        $tours = $this->staff(Role::Tours);

        $this->actingAs($tours)->patch("/admin/requests/{$cancelled->id}", ['status' => 'confirmed'])->assertSessionHasErrors('status');
        $this->assertSame(LeadStatus::Cancelled, $cancelled->fresh()?->status);
        $this->assertSame(2, Tours::remaining($date, $time));

        // With room again it goes back, and takes its places.
        Setting::put('tour_slot_capacity', '12');
        $this->actingAs($tours)->patch("/admin/requests/{$cancelled->id}", ['status' => 'confirmed'])->assertSessionHasNoErrors();
        $this->assertSame(LeadStatus::Confirmed, $cancelled->fresh()?->status);
        $this->assertSame(0, Tours::remaining($date, $time));
    }

    public function test_new_request_emails_go_to_the_team_inbox_and_applications_never_reach_the_other_teams(): void
    {
        config(['gdl.notify' => 'office@example.com', 'gdl.notify_teams' => ['tour' => 'tours@example.com', 'trade' => '', 'application' => 'hr@example.com']]);
        [$date, $time] = $this->slot();

        $this->post('/tours', $this->contact(['slot' => "$date $time", 'adults' => 2, 'group_type' => 'family']))->assertRedirect('/thanks');
        $this->post('/trade', $this->contact(['organisation' => 'Harbour Wines', 'country' => 'Canada', 'business_type' => 'importer', 'volume' => 'pallet', 'licensed' => 'yes', 'message' => 'Hello']))->assertRedirect('/thanks');
        $this->post('/careers/apply', $this->contact(['email' => 'cv@example.com', 'job' => 'general', 'parish' => 'st_george', 'experience' => '3_5', 'qualification' => 'cxc', 'consent' => '1',
            'cv' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf')]))->assertRedirect('/thanks');

        $sentTo = fn (LeadType $type) => collect(Notification::sent(new AnonymousNotifiable, NewLead::class))
            ->filter(fn (NewLead $n) => $n->lead->type === $type)->count();
        $this->assertSame(3, $sentTo(LeadType::Tour) + $sentTo(LeadType::Trade) + $sentTo(LeadType::Application));
        Notification::assertSentTo(new AnonymousNotifiable, NewLead::class, fn ($n, $c, $to) => $n->lead->type !== LeadType::Tour || $to->routes['mail'] === ['tours@example.com']);
        Notification::assertSentTo(new AnonymousNotifiable, NewLead::class, fn ($n, $c, $to) => $n->lead->type !== LeadType::Trade || $to->routes['mail'] === ['office@example.com']);
        Notification::assertSentTo(new AnonymousNotifiable, NewLead::class, fn ($n, $c, $to) => $n->lead->type !== LeadType::Application || $to->routes['mail'] === ['hr@example.com']);
        Notification::assertNotSentTo(new AnonymousNotifiable, NewLead::class, fn ($n, $c, $to) => $n->lead->type === LeadType::Application && in_array('office@example.com', (array) $to->routes['mail'], true));

        // Only team inboxes set: the dashboard does not claim nobody is emailed, and typos anywhere are listed.
        config(['gdl.notify' => '', 'gdl.notify_teams' => ['tour' => 'tours@example.com, oops', 'trade' => '', 'application' => '']]);
        $this->assertTrue(Notify::anyRecipients());
        $this->assertSame(['oops'], Notify::invalid());
    }

    public function test_a_timeline_entry_can_cite_more_than_one_source(): void
    {
        $this->ofAge()->get('/heritage')->assertOk()
            ->assertSee('Sources:')
            ->assertSee('Wee FM Grenada, April 2021');
    }

    /** The length a migration gives a string column, e.g. string('phone_digits', 30). */
    private function columnLength(string $column): int
    {
        $source = implode("\n", array_map('file_get_contents', glob(database_path('migrations/*.php')) ?: []));

        return preg_match("/string\('".preg_quote($column, '/')."', (\d+)\)/", $source, $m) ? (int) $m[1] : 255;
    }
}
