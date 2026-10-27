<?php

namespace Tests\Feature;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use App\Enums\LeadType;
use App\Models\JobPosting;
use App\Models\Lead;
use App\Notifications\LeadReceived;
use App\Notifications\NewLead;
use App\Support\Rums;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LeadFlowsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['gdl.notify' => 'office@example.com, not-an-email']);
        Notification::fake();
        Storage::fake('local');
    }

    private function job(array $overrides = []): JobPosting
    {
        $slug = $overrides['slug'] ?? 'inventory-controller';

        return JobPosting::where('slug', $slug)->first() ?? JobPosting::create($overrides + [
            'slug' => 'inventory-controller', 'title' => 'Inventory Controller', 'department' => 'Warehouse & logistics',
            'employment_type' => EmploymentType::FullTime, 'status' => JobStatus::Open, 'location' => 'Woodlands, St George',
            'summary' => 'Keeps stock records of raw materials and finished goods.',
        ]);
    }

    // ------------------------------------------------------------ trade

    /** @return array<string, mixed> */
    private function tradeData(array $overrides = []): array
    {
        return array_merge($this->contact(['email' => 'buyer@harbourwines.example']), [
            'organisation' => 'Harbour Wines Ltd', 'country' => 'Canada', 'business_type' => 'importer',
            'products' => [array_key_first(Rums::all())], 'volume' => 'pallet', 'licensed' => 'yes',
            'message' => 'We import Caribbean rum into Ontario and would like a price list.',
        ], $overrides);
    }

    public function test_trade_enquiry_gets_a_reference_and_reaches_the_office(): void
    {
        $this->post('/trade', $this->tradeData())->assertRedirect('/thanks');

        $lead = Lead::sole();
        $this->assertMatchesRegularExpression('/^TE-\d{2}-\d{5}$/', $lead->reference);
        $this->assertSame(LeadType::Trade, $lead->type);
        $this->assertSame('Harbour Wines Ltd', $lead->organisation);
        $this->assertSame('Harbour Wines Ltd, Canada', $lead->subject());
        $this->assertSame(Rums::all()[array_key_first(Rums::all())]['name'], $lead->productNames());
        // The typo in GDL_NOTIFY_EMAIL is skipped, the valid inbox still gets it.
        Notification::assertSentTo(new AnonymousNotifiable, NewLead::class, fn ($n, $c, $to) => $to->routes['mail'] === ['office@example.com']);
        Notification::assertSentTo(new AnonymousNotifiable, LeadReceived::class, fn ($n, $c, $to) => $to->routes['mail'] === 'buyer@harbourwines.example');
        $this->ofAge()->get('/thanks')->assertSee($lead->reference)->assertSee('export team');
    }

    public function test_trade_enquiry_validates_company_country_and_products(): void
    {
        $this->post('/trade', $this->tradeData(['organisation' => '', 'country' => '']))->assertSessionHasErrors(['organisation', 'country']);
        $this->post('/trade', $this->tradeData(['products' => ['not-a-rum']]))->assertSessionHasErrors('products.0');
        $this->post('/trade', $this->tradeData(['company_site' => 'javascript:alert(1)']))->assertSessionHasErrors('company_site');
        $this->post('/trade', $this->tradeData(['volume' => 'a ship']))->assertSessionHasErrors('volume');
        $this->assertSame(0, Lead::count());
    }

    // ------------------------------------------------------------ careers

    /** @return array<string, mixed> */
    private function applicationData(array $overrides = []): array
    {
        return array_merge($this->contact(), [
            'job' => (string) $this->job()->id, 'parish' => 'st_george', 'experience' => '3_5', 'qualification' => 'associate',
            'cv' => UploadedFile::fake()->create('kezia-charles-cv.pdf', 240, 'application/pdf'), 'consent' => '1',
        ], $overrides);
    }

    public function test_application_with_cv_goes_to_the_private_disk(): void
    {
        $this->post('/careers/apply', $this->applicationData())->assertRedirect('/thanks');

        $lead = Lead::sole();
        $this->assertMatchesRegularExpression('/^JA-\d{2}-\d{5}$/', $lead->reference);
        $this->assertSame('Inventory Controller', $lead->subject());
        $this->assertNotNull($lead->consented_at);
        $file = $lead->files()->sole();
        $this->assertSame('cv', $file->kind);
        $this->assertSame('kezia-charles-cv.pdf', $file->original_name);
        $this->assertStringStartsWith('leads/'.$lead->id.'/', $file->path);
        Storage::disk('local')->assertExists($file->path);
        $this->assertFileDoesNotExist(public_path($file->path));
        // The office email never carries the CV.
        Notification::assertSentTo(new AnonymousNotifiable, NewLead::class, fn (NewLead $n) => str_contains(implode(' ', $n->toMail(new AnonymousNotifiable)->introLines), 'The CV is in the back office.'));
    }

    public function test_general_application_without_a_vacancy(): void
    {
        $this->post('/careers/apply', $this->applicationData(['job' => 'general']))->assertRedirect('/thanks');
        $this->assertNull(Lead::sole()->job_posting_id);
        $this->assertSame('General application', Lead::sole()->subject());
    }

    public function test_application_refuses_missing_or_unsafe_cvs_and_closed_vacancies(): void
    {
        $this->post('/careers/apply', $this->applicationData(['cv' => null]))->assertSessionHasErrors(['cv' => 'Please attach your CV.']);
        $this->post('/careers/apply', $this->applicationData(['cv' => UploadedFile::fake()->create('cv.exe', 10, 'application/x-msdownload')]))->assertSessionHasErrors('cv');
        $this->post('/careers/apply', $this->applicationData(['cv' => UploadedFile::fake()->create('cv.pdf', 6000, 'application/pdf')]))->assertSessionHasErrors(['cv' => 'Your CV must be 5 MB or smaller.']);
        $this->post('/careers/apply', $this->applicationData(['consent' => null]))->assertSessionHasErrors('consent');

        $closed = $this->job(['slug' => 'accounts-clerk', 'title' => 'Accounts Clerk', 'status' => JobStatus::Closed]);
        $this->post('/careers/apply', $this->applicationData(['job' => (string) $closed->id]))->assertSessionHasErrors('job');
        $past = $this->job(['slug' => 'old', 'title' => 'Old', 'closes_on' => today()->subDay()]);
        $this->post('/careers/apply', $this->applicationData(['job' => (string) $past->id]))->assertSessionHasErrors('job');
        $this->assertSame(0, Lead::count());
    }

    public function test_careers_lists_only_open_vacancies_and_hides_drafts(): void
    {
        $open = $this->job();
        $draft = $this->job(['slug' => 'draft-role', 'title' => 'Draft Role', 'status' => JobStatus::Draft]);
        $closed = $this->job(['slug' => 'closed-role', 'title' => 'Closed Role', 'status' => JobStatus::Closed]);

        $this->ofAge()->get('/careers')->assertOk()->assertSee($open->title)->assertDontSee('Draft Role')->assertDontSee('Closed Role');
        $this->ofAge()->get('/careers/'.$open->slug)->assertOk()->assertSee('JobPosting', false);
        $this->ofAge()->get('/careers/'.$draft->slug)->assertNotFound();
        $this->ofAge()->get('/careers/'.$closed->slug)->assertOk()->assertSee('no longer taking applications');
        $this->ofAge()->get('/careers/apply?job='.$open->slug)->assertOk()->assertSee('value="'.$open->id.'" selected', false);
    }

    // ------------------------------------------------------------ contact

    public function test_contact_message_needs_only_an_email(): void
    {
        $this->post('/contact', $this->contact(['phone' => '', 'topic' => 'general', 'message' => 'Do you ship to St Lucia?']))->assertRedirect('/thanks');
        $lead = Lead::sole();
        $this->assertMatchesRegularExpression('/^EN-\d{2}-\d{5}$/', $lead->reference);
        $this->assertNull($lead->phone);
        $this->post('/contact', $this->contact(['topic' => 'nonsense', 'message' => 'x']))->assertSessionHasErrors('topic');
        $this->post('/contact', $this->contact(['topic' => 'general', 'message' => '']))->assertSessionHasErrors('message');
    }

    public function test_thanks_without_a_submission_goes_home(): void
    {
        $this->ofAge()->get('/thanks')->assertRedirect('/');
    }

    public function test_forms_are_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/contact', $this->contact(['topic' => 'general', 'message' => 'Hello '.$i]));
        }
        $this->post('/contact', $this->contact(['topic' => 'general', 'message' => 'One more']))->assertStatus(429);
    }
}
