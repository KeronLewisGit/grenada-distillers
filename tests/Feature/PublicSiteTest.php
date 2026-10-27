<?php

namespace Tests\Feature;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use App\Http\Middleware\AgeGate;
use App\Models\JobPosting;
use App\Support\Hours;
use App\Support\Rums;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    /** @return list<string> */
    private function innerPages(): array
    {
        return ['/rums', '/rums/'.array_key_first(Rums::all()), '/heritage', '/tours', '/trade', '/careers', '/careers/apply', '/contact', '/sitemap', '/privacy', '/photo-credits'];
    }

    public function test_every_public_page_renders(): void
    {
        JobPosting::create(['slug' => 'production-manager', 'title' => 'Production Manager', 'department' => 'Production', 'employment_type' => EmploymentType::FullTime,
            'status' => JobStatus::Open, 'location' => 'Woodlands, St George', 'summary' => 'Leads distilling and bottling.']);

        foreach (array_merge(['/', '/careers/production-manager'], $this->innerPages()) as $url) {
            $this->ofAge()->get($url)->assertOk()->assertSee("Clarke's Court", false)->assertSee('Grenada Distillers');
        }
        foreach (array_keys(Rums::all()) as $key) {
            $this->ofAge()->get('/rums/'.$key)->assertOk()->assertSee((string) Rums::get($key)['name'], false);
        }
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('careers.show', 'production-manager'), false)->assertSee(route('rums.show', array_key_first(Rums::all())), false);
    }

    public function test_every_inner_page_uses_the_shared_page_header(): void
    {
        foreach (array_merge($this->innerPages(), ['/age']) as $url) {
            $html = (string) $this->ofAge()->get($url)->getContent();
            $this->assertSame(1, substr_count($html, 'data-page-header'), "$url should open with exactly one <x-page-header>");
            $this->assertStringContainsString('class="hoops"', $html, $url);
        }
    }

    public function test_every_page_has_a_photo(): void
    {
        foreach (array_merge(['/'], $this->innerPages()) as $url) {
            $this->assertMatchesRegularExpression('#/img/[a-z0-9-]+-(480|960|1920)\.webp#', (string) $this->ofAge()->get($url)->getContent(), "$url has no photo");
        }
    }

    public function test_the_age_check_comes_first_and_remembers_the_answer(): void
    {
        $this->get('/')->assertRedirect('/age');
        $this->get('/tours?x=1')->assertRedirect('/age?next='.urlencode('/tours?x=1'));
        $this->get('/age')->assertOk()->assertSee((string) gdl('legal_age'))->assertSee('name="answer" value="yes"', false);

        $this->post('/age', ['answer' => 'yes', 'next' => '/tours', 'remember' => '1'])
            ->assertRedirect('/tours')->assertPlainCookie(AgeGate::COOKIE, '1');
        $this->post('/age', ['answer' => 'no'])->assertRedirect('/age?declined=1')->assertCookieMissing(AgeGate::COOKIE);
        $this->get('/age?declined=1')->assertSee('come back');
    }

    public function test_the_age_check_only_sends_people_back_to_this_site(): void
    {
        foreach (['https://evil.example', '//evil.example', '/\\evil.example', 'javascript:alert(1)', '/age'] as $next) {
            $this->post('/age', ['answer' => 'yes', 'next' => $next])->assertRedirect('/');
        }
    }

    public function test_legal_pages_and_the_sitemap_skip_the_age_check(): void
    {
        foreach (['/privacy', '/photo-credits', '/sitemap.xml', '/login'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_rum_pages_show_only_sourced_facts(): void
    {
        foreach (Rums::all() as $key => $rum) {
            $this->assertNotEmpty($rum['sources'] ?? [], "$key needs at least one source");
            $html = (string) $this->ofAge()->get('/rums/'.$key)->getContent();
            foreach ($rum['sources'] as $source) {
                $this->assertStringContainsString(e($source['url']), $html, "$key should cite its source");
            }
            $this->assertStringNotContainsStringIgnoringCase('award', $html, "$key: no awards unless the client supplies them");
        }
        $this->ofAge()->get('/rums/not-a-rum')->assertNotFound();
    }

    public function test_hours_are_worded_from_config(): void
    {
        config(['gdl.opening' => [1 => ['08:00', '16:00'], 2 => ['08:00', '16:00'], 3 => ['08:00', '16:00'], 4 => ['08:00', '16:00'], 5 => ['08:00', '15:30']]]);
        $this->assertSame('Monday to Thursday 8am to 4pm, Friday 8am to 3:30pm', Hours::summary());
        $this->assertSame(['Monday to Thursday' => '8am – 4pm', 'Friday' => '8am – 3:30pm', 'Saturday, Sunday and public holidays' => 'Closed'], Hours::rows());
    }

    public function test_preview_mode_adds_a_banner_and_noindex(): void
    {
        config(['gdl.preview' => true]);
        $this->ofAge()->get('/')->assertSee('Concept preview')->assertSee('noindex', false)->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_old_site_addresses_redirect(): void
    {
        foreach ((array) config('gdl.legacy_redirects') as $old => $new) {
            $this->get('/'.ltrim($old, '/'))->assertStatus(301)->assertRedirect($new);
        }
    }

    public function test_security_headers_are_sent(): void
    {
        $this->ofAge()->get('/')->assertHeader('X-Content-Type-Options', 'nosniff')->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }
}
