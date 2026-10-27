<?php

namespace App\Http\Controllers;

use App\Enums\LeadType;
use App\Models\JobPosting;
use App\Models\Setting;
use App\Support\LeadIntake;
use App\Support\Rums;
use App\Support\Tours;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * The four public request flows: tour booking, trade/export enquiry, job application and
 * contact. Each validates, hands over to LeadIntake (reference + emails) and lands on /thanks.
 */
class LeadFormController extends Controller
{
    /** CVs: PDF or Word, up to 5 MB. */
    private const string CV_MIMES = 'mimes:pdf,doc,docx';

    // ---------------------------------------------------------------- tours

    public function tours(): View
    {
        return view('pages.tours', [
            'grid' => Tours::grid(),
            'capacity' => Setting::tourCapacity(),
            'maxParty' => Setting::tourMaxParty(),
        ]);
    }

    public function storeTour(Request $request): RedirectResponse
    {
        if (LeadIntake::isBot($request, LeadType::Tour)) {
            return to_route('thanks');
        }
        $maxParty = Setting::tourMaxParty();
        $data = $request->validate($this->contactRules() + [
            'country' => ['nullable', 'string', 'max:80'],
            'slot' => ['required', 'string', 'regex:/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/'],
            'adults' => ['required', 'integer', 'min:1', 'max:'.$maxParty],
            'children' => ['nullable', 'integer', 'min:0', 'max:'.$maxParty],
            'group_type' => ['required', Rule::in(array_keys((array) config('gdl.tours.group_types')))],
            'staying' => ['nullable', 'string', 'max:120'],
            'access' => ['nullable', 'string', 'max:500'],
            'message' => ['nullable', 'string', 'max:1500'],
        ], [
            'slot.required' => 'Choose a day and time for your tour.',
            'slot.regex' => 'Choose a day and time from the list.',
            'adults.max' => "Online bookings take up to {$maxParty} guests. For a larger group, please send us an enquiry.",
        ], ['adults' => 'number of adults']);

        [$date, $time] = explode(' ', $data['slot']);
        $guests = (int) $data['adults'] + (int) ($data['children'] ?? 0);
        if ($guests > $maxParty) {
            return back()->withInput()->withErrors(['adults' => "Online bookings take up to {$maxParty} guests in total. For a larger group, please send us an enquiry."])->withFragment('book');
        }
        if (! Tours::isBookable($date, $time)) {
            return back()->withInput()->withErrors(['slot' => 'Tours do not run at that time. Choose a day and time from the list.'])->withFragment('book');
        }

        // The slot's places are checked and claimed under a lock, so two parties can't both take the last ones.
        try {
            return Cache::lock('tour-slot:'.$date.' '.$time, 10)->block((int) config('gdl.tours.lock_wait', 5), function () use ($data, $request, $date, $time, $guests) {
            $left = Tours::remaining($date, $time);
            if ($left < $guests) {
                return back()->withInput()->withErrors(['slot' => $left === 0
                    ? 'That tour has just filled up. Please choose another time.'
                    : "That tour has only {$left} ".($left === 1 ? 'place' : 'places').' left. Choose another time or a smaller party.'])->withFragment('book');
            }
            LeadIntake::create(LeadType::Tour, $this->contactFields($data) + [
                'country' => $data['country'] ?? null,
                'visit_date' => $date,
                'visit_time' => $time,
                'guests' => $guests,
                'message' => $data['message'] ?? null,
                'details' => [
                    'adults' => (int) $data['adults'],
                    'children' => (int) ($data['children'] ?? 0),
                    'group_type' => $data['group_type'],
                    'staying' => $data['staying'] ?? null,
                    'access' => $data['access'] ?? null,
                ],
            ], [], $request);

            return to_route('thanks');
            });
        } catch (LockTimeoutException) {
            return back()->withInput()->withErrors(['slot' => 'Lots of people are booking that tour right now. Please press Book again in a moment.'])->withFragment('book');
        }
    }

    // ---------------------------------------------------------------- trade

    public function trade(): View
    {
        return view('pages.trade', ['products' => Rums::options()]);
    }

    public function storeTrade(Request $request): RedirectResponse
    {
        if (LeadIntake::isBot($request, LeadType::Trade)) {
            return to_route('thanks');
        }
        $data = $request->validate($this->contactRules() + [
            'organisation' => ['required', 'string', 'max:160'],
            'job_title' => ['nullable', 'string', 'max:120'],
            'country' => ['required', 'string', 'max:80'],
            'business_type' => ['required', Rule::in(array_keys((array) config('gdl.trade.business_types')))],
            'markets' => ['nullable', 'string', 'max:300'],
            'products' => ['nullable', 'array'],
            'products.*' => [Rule::in(array_keys(Rums::options()))],
            'volume' => ['required', Rule::in(array_keys((array) config('gdl.trade.volumes')))],
            'licensed' => ['required', Rule::in(['yes', 'in_progress', 'no'])],
            'company_site' => ['nullable', 'url:http,https', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ], ['company_site.url' => 'Enter the full web address, starting with https://'], ['organisation' => 'company name', 'business_type' => 'type of business', 'licensed' => 'import licence']);

        LeadIntake::create(LeadType::Trade, $this->contactFields($data) + [
            'organisation' => trim($data['organisation']),
            'country' => trim($data['country']),
            'message' => $data['message'],
            'details' => [
                'job_title' => $data['job_title'] ?? null,
                'business_type' => $data['business_type'],
                'markets' => $data['markets'] ?? null,
                'products' => array_values($data['products'] ?? []),
                'volume' => $data['volume'],
                'licensed' => $data['licensed'],
                'company_site' => $data['company_site'] ?? null,
            ],
        ], [], $request);

        return to_route('thanks');
    }

    // ---------------------------------------------------------------- careers

    public function apply(Request $request): View
    {
        $jobs = JobPosting::open()->orderBy('title')->get();

        return view('pages.careers.apply', [
            'jobs' => $jobs,
            'selected' => $jobs->firstWhere('slug', input_string($request->query('job'))),
        ]);
    }

    public function storeApplication(Request $request): RedirectResponse
    {
        if (LeadIntake::isBot($request, LeadType::Application)) {
            return to_route('thanks');
        }
        $data = $request->validate($this->contactRules() + [
            'job' => ['required', 'string', function (string $attr, mixed $value, \Closure $fail) {
                if ($value !== 'general' && ! JobPosting::open()->whereKey((int) $value)->exists()) {
                    $fail('That vacancy has closed. Choose another, or send a general application.');
                }
            }],
            'parish' => ['required', Rule::in(array_keys((array) config('gdl.parishes')))],
            'experience' => ['required', Rule::in(array_keys((array) config('gdl.careers.experience')))],
            'qualification' => ['required', Rule::in(array_keys((array) config('gdl.careers.qualifications')))],
            'available_from' => ['nullable', 'date', 'after_or_equal:today'],
            'current_role' => ['nullable', 'string', 'max:160'],
            'cv' => ['required', 'file', self::CV_MIMES, 'max:5120'],
            'message' => ['nullable', 'string', 'max:3000'],
            'consent' => ['accepted'],
        ], [
            'job.required' => 'Choose the vacancy you are applying for, or a general application.',
            'cv.required' => 'Please attach your CV.',
            'cv.mimes' => 'Your CV must be a PDF or Word document.',
            'cv.max' => 'Your CV must be 5 MB or smaller.',
            'cv.uploaded' => 'Your CV did not upload. It must be 5 MB or smaller.',
            'consent.accepted' => 'Please agree that we may keep your application for 12 months.',
        ], ['available_from' => 'start date', 'current_role' => 'current or last job']);

        LeadIntake::create(LeadType::Application, $this->contactFields($data) + [
            'job_posting_id' => $data['job'] === 'general' ? null : (int) $data['job'],
            'country' => 'Grenada',
            'consented_at' => now(),
            'message' => $data['message'] ?? null,
            'details' => [
                'parish' => $data['parish'],
                'experience' => $data['experience'],
                'qualification' => $data['qualification'],
                'available_from' => $data['available_from'] ?? null,
                'current_role' => $data['current_role'] ?? null,
            ],
        ], ['cv' => array_filter([$request->file('cv')])], $request);

        return to_route('thanks');
    }

    // ---------------------------------------------------------------- contact

    public function storeEnquiry(Request $request): RedirectResponse
    {
        if (LeadIntake::isBot($request, LeadType::Enquiry)) {
            return to_route('thanks');
        }
        $data = $request->validate($this->contactRules(phoneRequired: false) + [
            'topic' => ['required', Rule::in(array_keys((array) config('gdl.enquiry_topics')))],
            'country' => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'max:3000'],
        ]);
        LeadIntake::create(LeadType::Enquiry, $this->contactFields($data) + [
            'country' => $data['country'] ?? null,
            'message' => $data['message'],
            'details' => ['topic' => $data['topic']],
        ], [], $request);

        return to_route('thanks');
    }

    public function thanks(Request $request): View|RedirectResponse
    {
        $last = $request->session()->get('last_lead');

        return is_array($last) ? view('pages.thanks', ['reference' => $last['reference'], 'type' => LeadType::tryFrom($last['type']) ?? LeadType::Enquiry]) : to_route('home');
    }

    // ---------------------------------------------------------------- shared

    /** @return array<string, list<mixed>> */
    private function contactRules(bool $phoneRequired = true): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'phone' => [$phoneRequired ? 'required' : 'nullable', 'string', 'max:30', 'regex:/^[0-9+()\-. ]{7,}$/'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'contact_pref' => ['nullable', Rule::in(['email', 'phone', 'whatsapp'])],
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function contactFields(array $data): array
    {
        return [
            'name' => trim((string) $data['name']),
            'phone' => isset($data['phone']) ? trim((string) $data['phone']) : null,
            'email' => strtolower(trim((string) $data['email'])),
            'contact_pref' => $data['contact_pref'] ?? 'email',
        ];
    }
}
