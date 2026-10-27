<?php

namespace Tests\Feature;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Enums\Role;
use App\Models\JobPosting;
use App\Models\Lead;
use App\Models\Setting;
use App\Models\User;
use App\Support\Tours;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function applicationWithCv(): Lead
    {
        Storage::fake('local');
        $lead = Lead::factory()->application()->create(['name' => 'Applicant Person']);
        $lead->files()->create(['kind' => 'cv', 'path' => UploadedFile::fake()->create('cv.pdf', 20)->store('leads/'.$lead->id, 'local'), 'original_name' => 'cv.pdf', 'mime' => 'application/pdf', 'size' => 20480]);

        return $lead;
    }

    public function test_guests_are_sent_to_login(): void
    {
        foreach (['/admin', '/admin/requests', '/admin/tours', '/admin/vacancies', '/admin/settings', '/admin/users'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
    }

    public function test_staff_sign_in_and_inactive_accounts_cannot(): void
    {
        $user = User::factory()->role(Role::Tours)->create(['email' => 'guide@clarkescourt.test']);
        $this->post('/login', ['email' => 'GUIDE@clarkescourt.test', 'password' => 'password'])->assertRedirect('/admin');
        $this->post('/logout');

        $user->update(['active' => false]);
        $this->post('/login', ['email' => 'guide@clarkescourt.test', 'password' => 'password'])->assertSessionHasErrors('email');
        // Switched off while signed in: signed out on the next request (EnsureActive).
        $this->actingAs($user)->get('/admin')->assertRedirect('/login');
    }

    public function test_dashboard_leads_with_requests_waiting_over_a_day(): void
    {
        $tours = $this->staff(Role::Tours);
        [$date, $time] = [Tours::days()[0]->toDateString(), Tours::times(Tours::days()[0])[0]];
        $old = Lead::factory()->tour($date, $time)->create();
        $old->forceFill(['created_at' => now()->subHours(30)])->save();
        Lead::factory()->tour($date, $time)->create(); // fresh, inside the window
        $hidden = Lead::factory()->trade()->create(['name' => 'Hidden Trader']);
        $hidden->forceFill(['created_at' => now()->subDays(3)])->save(); // the trade desk's, not tours'

        $this->actingAs($tours)->get('/admin')->assertOk()
            ->assertSeeInOrder(['1', 'request has waited more than a working day'], false)
            ->assertSee('Reply to them now')
            ->assertSee('Guests booked, next 7 days');
        $this->actingAs($tours)->get('/admin/requests?overdue=1')->assertSee($old->name)->assertDontSee('Hidden Trader');
    }

    public function test_each_role_sees_only_its_own_request_types(): void
    {
        $tour = Lead::factory()->tour(Tours::days()[0]->toDateString(), '10:00')->create(['name' => 'Tour Guest']);
        $trade = Lead::factory()->trade()->create(['name' => 'Trade Buyer']);
        $app = Lead::factory()->application()->create(['name' => 'Job Seeker']);
        $enq = Lead::factory()->create(['name' => 'General Asker']);

        $seen = [
            Role::Tours->value => ['Tour Guest', 'General Asker'],
            Role::Trade->value => ['Trade Buyer', 'General Asker'],
            Role::Hr->value => ['Job Seeker'],
            Role::Admin->value => ['Tour Guest', 'Trade Buyer', 'Job Seeker', 'General Asker'],
        ];
        foreach ($seen as $role => $names) {
            $user = $this->staff(Role::from($role));
            $page = $this->actingAs($user)->get('/admin/requests')->assertOk();
            foreach (['Tour Guest', 'Trade Buyer', 'Job Seeker', 'General Asker'] as $name) {
                in_array($name, $names, true) ? $page->assertSee($name) : $page->assertDontSee($name);
            }
            foreach ([$tour, $trade, $app, $enq] as $lead) {
                $this->actingAs($user)->get('/admin/requests/'.$lead->id)->assertStatus(in_array($lead->name, $names, true) ? 200 : 403);
            }
        }
    }

    public function test_only_hr_and_admins_open_cvs_and_each_opening_is_logged(): void
    {
        $lead = $this->applicationWithCv();
        $file = $lead->files()->sole();

        foreach ([Role::Tours, Role::Trade] as $role) {
            $this->actingAs($this->staff($role))->get("/admin/requests/{$lead->id}/files/{$file->id}")->assertForbidden();
        }
        foreach ([Role::Hr, Role::Admin] as $role) {
            $this->actingAs($this->staff($role))->get("/admin/requests/{$lead->id}/files/{$file->id}")->assertOk()->assertHeader('Cache-Control', 'no-store, private');
        }
        $this->assertSame(2, $lead->notes()->where('body', 'like', 'Opened CV%')->count());

        // A file id from another request never opens through this one.
        $other = Lead::factory()->application()->create();
        $this->actingAs($this->staff(Role::Hr))->get("/admin/requests/{$other->id}/files/{$file->id}")->assertForbidden();
    }

    public function test_status_follows_the_request_type_and_logs_a_note(): void
    {
        $hr = $this->staff(Role::Hr);
        $lead = Lead::factory()->application()->create();

        $this->actingAs($hr)->patch('/admin/requests/'.$lead->id, ['status' => 'interview'])->assertSessionHasNoErrors();
        $this->assertSame(LeadStatus::Interview, $lead->fresh()?->status);
        $this->assertNotNull($lead->fresh()?->first_contacted_at);
        $this->actingAs($hr)->patch('/admin/requests/'.$lead->id, ['status' => 'samples'])->assertSessionHasErrors('status');
        $this->assertSame(LeadStatus::Interview, $lead->fresh()?->status);
        $this->assertTrue($lead->notes()->where('body', 'Status changed to Interview.')->exists());
    }

    public function test_logging_a_first_reply_moves_the_request_on(): void
    {
        $tours = $this->staff(Role::Tours);
        $lead = Lead::factory()->tour(Tours::days()[0]->toDateString(), '10:00')->create();
        $this->actingAs($tours)->post('/admin/requests/'.$lead->id.'/notes', ['body' => 'Emailed the guest.', 'contacted' => '1'])->assertRedirect();
        $this->assertSame(LeadStatus::Confirmed, $lead->fresh()?->status);
    }

    public function test_requests_can_only_be_assigned_to_staff_who_can_see_them(): void
    {
        $admin = $this->staff(Role::Admin);
        $hr = $this->staff(Role::Hr);
        $trade = $this->staff(Role::Trade);
        $lead = Lead::factory()->trade()->create();

        $this->actingAs($admin)->patch('/admin/requests/'.$lead->id, ['assigned_to' => $hr->id])->assertSessionHasErrors('assigned_to');
        $this->actingAs($admin)->patch('/admin/requests/'.$lead->id, ['assigned_to' => $trade->id])->assertSessionHasNoErrors();
        $this->assertSame($trade->id, $lead->fresh()?->assigned_to);
    }

    public function test_role_areas_are_locked_to_their_roles(): void
    {
        $areas = ['/admin/tours' => [Role::Admin, Role::Tours], '/admin/vacancies' => [Role::Admin, Role::Hr], '/admin/settings' => [Role::Admin], '/admin/users' => [Role::Admin]];
        foreach ($areas as $url => $allowed) {
            foreach (Role::cases() as $role) {
                $this->actingAs($this->staff($role))->get($url)->assertStatus(in_array($role, $allowed, true) ? 200 : 403);
            }
        }
    }

    public function test_tour_calendar_shows_the_day_sheet(): void
    {
        $day = Tours::days()[0];
        $time = Tours::times($day)[0];
        Lead::factory()->tour($day->toDateString(), $time, 5)->create(['name' => 'Sheet Guest']);
        Lead::factory()->tour($day->toDateString(), $time, 3)->create(['name' => 'Gone Guest', 'status' => LeadStatus::Cancelled]);

        $this->actingAs($this->staff(Role::Tours))->get('/admin/tours?day='.$day->toDateString())->assertOk()
            ->assertSee('Sheet Guest')->assertSee('5 of '.Setting::tourCapacity().' places')
            ->assertSee('Gone Guest');
        $this->actingAs($this->staff(Role::Tours))->get('/admin/tours?day=2026-02-30&month=2026-13')->assertOk();
    }

    public function test_hr_manages_vacancies_and_used_ones_are_closed_not_deleted(): void
    {
        $hr = $this->staff(Role::Hr);
        $this->actingAs($hr)->post('/admin/vacancies', [
            'title' => 'Accounts Clerk', 'department' => 'Finance & accounts', 'employment_type' => 'full_time', 'status' => 'open',
            'location' => 'Woodlands, St George', 'summary' => 'Keeps the ledgers.', 'duties' => "Payables\nReceivables",
        ])->assertRedirect();
        $job = JobPosting::sole();
        $this->assertSame('accounts-clerk', $job->slug);
        $this->assertSame(['Payables', 'Receivables'], $job->lines('duties'));

        Lead::factory()->application()->create(['job_posting_id' => $job->id]);
        $this->actingAs($hr)->delete('/admin/vacancies/'.$job->slug)->assertRedirect('/admin/vacancies');
        $this->assertSame(JobStatus::Closed, $job->fresh()?->status);

        $empty = JobPosting::create(['slug' => 'empty', 'title' => 'Empty', 'department' => 'Production', 'employment_type' => EmploymentType::FullTime, 'status' => JobStatus::Draft, 'location' => 'Woodlands', 'summary' => 'x']);
        $this->actingAs($hr)->delete('/admin/vacancies/empty');
        $this->assertNull($empty->fresh());
    }

    public function test_admin_sets_tour_capacity_and_party_size(): void
    {
        $admin = $this->staff(Role::Admin);
        $this->actingAs($admin)->put('/admin/settings', ['tour_slot_capacity' => 15, 'tour_max_party' => 20])->assertSessionHasErrors('tour_max_party');
        $this->actingAs($admin)->put('/admin/settings', ['tour_slot_capacity' => 15, 'tour_max_party' => 8])->assertSessionHasNoErrors();
        Setting::flush();
        $this->assertSame(15, Setting::tourCapacity());
        $this->assertSame(8, Setting::tourMaxParty());
    }

    public function test_admin_manages_staff_but_cannot_lock_themselves_out(): void
    {
        $admin = $this->staff(Role::Admin);
        $this->actingAs($admin)->post('/admin/users', ['name' => 'New Guide', 'email' => 'NEW@clarkescourt.test', 'role' => 'tours', 'password' => 'long-enough-1'])->assertSessionHasNoErrors();
        $this->assertSame(Role::Tours, User::where('email', 'new@clarkescourt.test')->sole()->role);

        $this->actingAs($admin)->patch('/admin/users/'.$admin->id, ['role' => 'tours', 'active' => '1'])->assertSessionHasErrors('role');
        $this->actingAs($admin)->patch('/admin/users/'.$admin->id, ['role' => 'admin'])->assertSessionHasErrors('role');
        $this->assertTrue($admin->fresh()?->active);
    }

    public function test_csv_export_is_scoped_and_formula_safe(): void
    {
        Lead::factory()->trade('=HYPERLINK("x")')->create(['name' => 'Trade Buyer']);
        Lead::factory()->application()->create(['name' => 'Job Seeker']);

        $csv = $this->actingAs($this->staff(Role::Trade))->get('/admin/requests/export')->assertOk()->streamedContent();
        $this->assertStringContainsString('Trade Buyer', $csv);
        $this->assertStringNotContainsString('Job Seeker', $csv);
        $this->assertStringContainsString("'=HYPERLINK", $csv);
    }

    public function test_search_finds_by_company_reference_and_phone(): void
    {
        $lead = Lead::factory()->trade('Northern Spirits AB', 'Sweden')->create(['phone' => '+46 8 123 4567']);
        $admin = $this->staff(Role::Admin);
        foreach (['Northern', $lead->fresh()?->reference, '1234567', 'Sweden'] as $q) {
            $this->actingAs($admin)->get('/admin/requests?q='.urlencode((string) $q))->assertSee('Northern Spirits AB');
        }
    }

    public function test_database_seeder_creates_only_the_first_admin(): void
    {
        config(['gdl.admin' => ['name' => 'First Admin', 'email' => 'Boss@Example.com', 'password' => 'a-long-password']]);
        $this->seed(DatabaseSeeder::class);
        $this->assertSame(Role::Admin, User::sole()->role);
        $this->assertSame('boss@example.com', User::sole()->email);
        $this->assertSame(0, Lead::count());
        $this->assertSame(0, JobPosting::count());
    }

    public function test_demo_seeder_builds_a_full_demo_and_every_admin_page_renders(): void
    {
        Storage::fake('local');
        $this->seed(DemoSeeder::class);
        $this->assertGreaterThan(50, Lead::count());
        foreach (LeadType::cases() as $type) {
            $this->assertTrue(Lead::where('type', $type)->exists(), $type->value);
        }
        $this->assertTrue(JobPosting::where('is_demo', true)->exists());
        $this->assertFalse(JobPosting::where('is_demo', false)->exists());

        foreach (['admin', 'tours', 'trade', 'hr'] as $role) {
            $user = User::where('email', $role.'@clarkescourt.test')->sole();
            foreach (['/admin', '/admin/requests', '/admin/requests?type=tour', '/admin/requests?status=open'] as $url) {
                $this->actingAs($user)->get($url)->assertOk();
            }
            foreach (Lead::visibleTo($user)->limit(12)->get() as $lead) {
                $this->actingAs($user)->get('/admin/requests/'.$lead->id)->assertOk();
            }
        }
        $admin = User::where('email', 'admin@clarkescourt.test')->sole();
        foreach (['/admin/tours', '/admin/vacancies', '/admin/vacancies/create', '/admin/users', '/admin/settings'] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
        $this->actingAs($admin)->get('/admin/vacancies/'.JobPosting::first()?->slug.'/edit')->assertOk();
    }
}
