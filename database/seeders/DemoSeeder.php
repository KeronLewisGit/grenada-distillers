<?php

namespace Database\Seeders;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use App\Enums\LeadStatus;
use App\Enums\LeadType;
use App\Enums\Role;
use App\Models\JobPosting;
use App\Models\Lead;
use App\Models\Setting;
use App\Models\User;
use App\Support\Rums;
use App\Support\Tours;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Pitch demo and local work: php artisan migrate:fresh --seeder=DemoSeeder
 *
 * Everything here is sample data and is marked so: vacancies are is_demo (a "Sample" badge),
 * and every request carries details.demo = true (a "Sample" chip in the back office). The
 * vacancy titles and duties follow ones Grenada Distillers advertised on NOW Grenada; the people, companies,
 * dates and numbers are made up. No prices, volumes or stock levels are invented.
 */
class DemoSeeder extends Seeder
{
    private const array FIRST = ['Kezia', 'Marlon', 'Shanice', 'Devon', 'Aaliyah', 'Kendell', 'Renée', 'Tevin', 'Gemma', 'Oliver', 'Hannah', 'Lukas', 'Priya', 'Marcus', 'Sophie', 'Jerome', 'Amara', 'Nikolai', 'Chloe', 'Darius', 'Ingrid', 'Ruth', 'Andre', 'Natalie'];

    private const array LAST = ['Charles', 'Mitchell', 'Antoine', 'Joseph', 'Bain', 'Noel', 'Frank', 'Phillip', 'Hughes', 'Thompson', 'Becker', 'Andersson', 'Patel', 'Walcott', 'Moreau', 'Baptiste', 'Okafor', 'Ivanov', 'Fraser', 'Celestine', 'Lindqvist', 'Modeste', 'Pierre', 'Clarke'];

    private const array COUNTRIES = ['United Kingdom', 'United States', 'Canada', 'Germany', 'Trinidad and Tobago', 'Barbados', 'Saint Lucia', 'Netherlands', 'Sweden', 'Grenada'];

    private int $n = 0;

    public function run(): void
    {
        mt_srand(1937);
        Setting::put('tour_slot_capacity', '20');
        Setting::put('tour_max_party', '12');

        $users = collect([
            ['admin@clarkescourt.test', 'Demo Administrator', Role::Admin],
            ['tours@clarkescourt.test', 'Demo Tour Guide', Role::Tours],
            ['tours2@clarkescourt.test', 'Second Tour Guide', Role::Tours],
            ['trade@clarkescourt.test', 'Demo Export Manager', Role::Trade],
            ['hr@clarkescourt.test', 'Demo HR Officer', Role::Hr],
        ])->mapWithKeys(fn (array $u) => [$u[2]->value.($u[0] === 'tours2@clarkescourt.test' ? '2' : '') => User::updateOrCreate(['email' => $u[0]], [
            'name' => $u[1], 'role' => $u[2], 'active' => true, 'password' => Hash::make('password'),
        ])]);

        $jobs = $this->vacancies();
        $this->tours($users->all());
        $this->trade($users->all());
        $this->applications($users->all(), $jobs);
        $this->enquiries($users->all());
    }

    /** @return list<JobPosting> */
    private function vacancies(): array
    {
        // Titles and duties follow vacancies Grenada Distillers advertised on NOW Grenada (2024-26);
        // closing dates are sample dates.
        $rows = [
            ['Sales and Marketing Manager', 'Sales & marketing', 'Leads the sales and marketing teams to grow the Clarke\'s Court brand at home and in new export markets.',
                "Manage the sales and marketing teams to meet and exceed targets\nDevelop and run sales and marketing plans, campaigns, launches and events\nManage corporate communications and media relations\nExplore new export markets with the General Manager\nPrepare the annual sales budget and the monthly department report",
                "Degree in business, marketing or a related field\nKnowledge of digital and social-media marketing\nExperience with forecasting, data analysis and report writing\nStrong leadership, communication and presentation skills", today()->addDays(24)],
            ['Blending Technician', 'Production', 'Makes the in-process and final rum blends to documented instructions and checks their quality.',
                "Transfer ingredients from tanks, casks, totes and drums to make blends\nTest strength, brix, pH, colour and taste of blends and inputs\nHelp manage the cask room\nHelp with the monthly stock-take in blending",
                "Associate degree in natural science\nAt least 2 years in a manufacturing environment\nKnowledge of HACCP and good manufacturing practice\nComfortable wearing PPE in a physical job", today()->addDays(17)],
            ['Warehouse Assistant', 'Warehouse & logistics', 'Stores and records all inventory so production and distribution run to plan.',
                "Store raw materials, packaging and finished goods correctly\nKeep accurate inventory records\nLoad and deliver orders",
                "Valid driver's licence (F & D class) with a clean record\nAble to lift moderate to heavy goods\nAt least 2 years in a manufacturing or warehouse environment", null],
        ];

        return array_map(fn (array $r, int $i) => JobPosting::updateOrCreate(['slug' => Str::slug($r[0])], [
            'title' => $r[0], 'department' => $r[1], 'employment_type' => EmploymentType::FullTime, 'status' => JobStatus::Open,
            'location' => 'Woodlands, St George', 'closes_on' => $r[5], 'summary' => $r[2], 'duties' => $r[3], 'requirements' => $r[4], 'is_demo' => true,
        ]), $rows, array_keys($rows));
    }

    /** @param array<string, User> $users */
    private function tours(array $users): void
    {
        $groupTypes = array_keys((array) config('gdl.tours.group_types'));
        // Past tours over the last four weeks, then bookings in the coming two weeks.
        for ($d = 28; $d >= -14; $d--) {
            $day = today()->subDays($d);
            $times = $this->timesOn($day);
            foreach ($times as $t) {
                $bookings = mt_rand(0, $d < 0 ? 3 : 2);
                for ($b = 0; $b < $bookings; $b++) {
                    $adults = Arr::random([1, 2, 2, 2, 3, 4, 6, 8]);
                    $children = mt_rand(0, 5) === 0 ? mt_rand(1, 2) : 0;
                    $created = $d > 0 ? $day->copy()->subDays(mt_rand(1, 10))->setTime(mt_rand(7, 21), mt_rand(0, 59)) : now()->subHours(mt_rand(2, 24 * 9));
                    $status = match (true) {
                        $d > 0 => Arr::random([LeadStatus::Attended, LeadStatus::Attended, LeadStatus::Attended, LeadStatus::NoShow, LeadStatus::Cancelled]),
                        $created->gt(now()->subHours(20)) => LeadStatus::New,
                        default => Arr::random([LeadStatus::Confirmed, LeadStatus::Confirmed, LeadStatus::Confirmed, LeadStatus::Confirmed, LeadStatus::Cancelled]),
                    };
                    $this->lead(LeadType::Tour, $created, $status, $users['tours'], [
                        'country' => Arr::random(self::COUNTRIES),
                        'visit_date' => $day->toDateString(), 'visit_time' => $t, 'guests' => $adults + $children,
                        'details' => ['adults' => $adults, 'children' => $children, 'group_type' => Arr::random($groupTypes),
                            'staying' => Arr::random([null, 'Grand Anse', 'Cruise ship, St George\'s', 'Lance aux Épines', 'True Blue']),
                            'access' => mt_rand(0, 9) === 0 ? 'One of us uses a walking frame.' : null],
                    ]);
                }
            }
        }
    }

    /** @param array<string, User> $users */
    private function trade(array $users): void
    {
        $companies = [
            ['Harbourside Spirits Ltd', 'United Kingdom', 'importer', 'England and Wales, independent bottle shops'],
            ['Maple Cask Imports', 'Canada', 'importer', 'Ontario (LCBO listings)'],
            ['Nordlys Drinks AB', 'Sweden', 'importer', 'Systembolaget tenders'],
            ['Rheinhafen Getränke GmbH', 'Germany', 'wholesaler', 'Germany and Austria'],
            ['Port Lounge Duty Free', 'Barbados', 'travel_retail', 'Airport and cruise terminal'],
            ['Southside Beverage Co.', 'United States', 'importer', 'Florida and Georgia'],
            ['Gulf Breeze Hotels', 'Trinidad and Tobago', 'on_trade', 'Two hotel bars'],
            ['Canal Street Liquor', 'Netherlands', 'retailer', 'Amsterdam'],
            ['Island Provisions Yacht Supply', 'Saint Lucia', 'cruise', 'Yacht charters, Rodney Bay'],
            ['Tamarind Bar & Kitchen', 'United Kingdom', 'on_trade', 'London'],
            ['Lakeshore Fine Wines', 'United States', 'retailer', 'Chicago'],
            ['Baltic Rum Club', 'Germany', 'other', 'Online rum club, 4,000 members'],
            ['Windward Distributors', 'Saint Vincent and the Grenadines', 'importer', 'SVG and the Grenadines'],
            ['Highland Cellars', 'United Kingdom', 'wholesaler', 'Scotland'],
            ['Pacific Rum Merchants', 'Canada', 'importer', 'British Columbia'],
            ['Alpine Spirits AG', 'Switzerland', 'importer', 'Switzerland'],
        ];
        $rums = array_keys(Rums::options());
        foreach ($companies as $i => [$org, $country, $type, $markets]) {
            $created = now()->subDays(mt_rand(0, 75))->subHours(mt_rand(0, 23));
            $status = match (true) {
                $i < 3 => LeadStatus::New,
                $i < 5 => LeadStatus::Contacted,
                $i < 8 => LeadStatus::Qualified,
                $i < 10 => LeadStatus::Samples,
                $i < 11 => LeadStatus::Signed,
                default => Arr::random([LeadStatus::Declined, LeadStatus::Contacted, LeadStatus::Qualified]),
            };
            if ($i < 3) {
                $created = now()->subHours([5, 30, 52][$i]);
            }
            $this->lead(LeadType::Trade, $created, $status, $users['trade'], [
                'organisation' => $org, 'country' => $country,
                'message' => Arr::random([
                    'We are looking to add a Grenadian rum to our Caribbean range. Could you send your export price list and spec sheets?',
                    'Our customers ask for overproof rum. Please tell us about availability, case sizes and lead times.',
                    'We would like samples of the aged rums for a tasting panel next month.',
                    'Interested in exclusive distribution for our region. Who should we speak to?',
                ]),
                'details' => ['job_title' => Arr::random(['Buyer', 'Managing Director', 'Category Manager', 'Owner', 'Head of Spirits']),
                    'business_type' => $type, 'markets' => $markets, 'products' => $rums === [] ? [] : Arr::random($rums, min(count($rums), mt_rand(1, 3))),
                    'volume' => Arr::random(['samples', 'cases', 'pallet', 'container', 'unsure']), 'licensed' => Arr::random(['yes', 'yes', 'in_progress', 'no']), 'company_site' => null],
            ]);
        }
    }

    /**
     * @param  array<string, User>  $users
     * @param  list<JobPosting>  $jobs
     */
    private function applications(array $users, array $jobs): void
    {
        $parishes = ['st_george', 'st_george', 'st_george', 'st_david', 'st_andrew', 'st_patrick', 'st_john', 'carriacou'];
        for ($i = 0; $i < 22; $i++) {
            $created = $i < 4 ? now()->subHours([3, 9, 28, 50][$i]) : now()->subDays(mt_rand(2, 40))->subHours(mt_rand(0, 23));
            $status = $i < 4 ? LeadStatus::New : Arr::random([LeadStatus::Reviewing, LeadStatus::Reviewing, LeadStatus::Interview, LeadStatus::Declined, LeadStatus::Offered]);
            $job = mt_rand(0, 5) === 0 ? null : $jobs[$i % count($jobs)];
            $lead = $this->lead(LeadType::Application, $created, $status, $users['hr'], [
                'country' => 'Grenada', 'job_posting_id' => $job?->id, 'consented_at' => $created,
                'message' => Arr::random([null, 'I am available immediately and live close to Woodlands.', 'Please find my CV attached. I would welcome the chance to interview.']),
                'details' => ['parish' => Arr::random($parishes), 'experience' => Arr::random(array_keys((array) config('gdl.careers.experience'))),
                    'qualification' => Arr::random(array_keys((array) config('gdl.careers.qualifications'))), 'available_from' => null,
                    'current_role' => Arr::random([null, 'Stores clerk', 'Shift supervisor', 'Accounts assistant', 'Quality technician'])],
            ], 'grd');
            $path = 'leads/'.$lead->id.'/demo-cv.pdf';
            Storage::disk('local')->put($path, $this->samplePdf($lead->name));
            $lead->files()->create(['kind' => 'cv', 'path' => $path, 'original_name' => strtolower(str_replace(' ', '-', $lead->name)).'-cv.pdf', 'mime' => 'application/pdf', 'size' => strlen($this->samplePdf($lead->name))]);
        }
    }

    /** @param array<string, User> $users */
    private function enquiries(array $users): void
    {
        $rows = [
            ['where_to_buy', 'Can I buy Clarke\'s Court in Toronto? I tried the #37 on holiday and loved it.', 'Canada'],
            ['tour_group', 'We are a group of 35 from a cruise ship arriving in March. Can you take us all at once?', 'United States'],
            ['events', 'We are planning a wedding in Grand Anse and would like to ask about rum for the reception.', 'Grenada'],
            ['media', 'I am writing a travel piece on Grenada\'s rum distilleries and would love to visit.', 'United Kingdom'],
            ['general', 'Do you sell gift boxes at the distillery shop?', 'Germany'],
            ['feedback', 'The label on my bottle was peeling, otherwise excellent rum.', 'Grenada'],
            ['where_to_buy', 'Is the Old Grog available in Trinidad?', 'Trinidad and Tobago'],
            ['general', 'Are tours wheelchair accessible?', 'United Kingdom'],
            ['events', 'Sponsorship request for a school sports day in St Andrew.', 'Grenada'],
            ['tour_group', 'Private tour for 14 colleagues on a Friday afternoon?', 'Barbados'],
        ];
        foreach ($rows as $i => [$topic, $message, $country]) {
            $created = $i < 2 ? now()->subHours([4, 27][$i]) : now()->subDays(mt_rand(1, 45));
            $this->lead(LeadType::Enquiry, $created, $i < 2 ? LeadStatus::New : Arr::random([LeadStatus::Replied, LeadStatus::Replied, LeadStatus::Closed]),
                $users[in_array($topic, ['tour_group', 'general'], true) ? 'tours' : 'trade'], [
                    'country' => $country, 'message' => $message, 'details' => ['topic' => $topic],
                ]);
        }
    }

    /** @param array<string, mixed> $attributes */
    private function lead(LeadType $type, Carbon $created, LeadStatus $status, User $assignee, array $attributes, string $phoneCountry = 'any'): Lead
    {
        $first = self::FIRST[$this->n % count(self::FIRST)];
        $last = self::LAST[intdiv($this->n, count(self::FIRST)) % count(self::LAST) + ($this->n % 7)] ?? 'Charles';
        $this->n++;
        $name = $first.' '.$last;
        $phone = $phoneCountry === 'grd' || ($attributes['country'] ?? '') === 'Grenada'
            ? sprintf('(473) %d-%04d', mt_rand(403, 449), mt_rand(0, 9999))
            : sprintf('+%d %d %04d %04d', Arr::random([1, 44, 49, 46, 31]), mt_rand(20, 99), mt_rand(0, 9999), mt_rand(0, 9999));

        $details = (array) ($attributes['details'] ?? []);
        $details['demo'] = true;
        $lead = Lead::create(array_merge($attributes, [
            'type' => $type, 'status' => LeadStatus::New, 'name' => $name, 'phone' => $phone,
            'email' => strtolower($first.'.'.$last.'@example.com'), 'contact_pref' => Arr::random(['email', 'email', 'phone', 'whatsapp']),
            'details' => $details, 'source_url' => url('/'),
        ]));
        $lead->forceFill(['created_at' => $created, 'updated_at' => $created])->saveQuietly();
        $lead->forceFill(['reference' => sprintf('%s-%s-%05d', $type->prefix(), $created->format('y'), $lead->id)])->saveQuietly();
        $lead->notes()->create(['kind' => 'system', 'body' => 'Received from the website'.($lead->subject() ? ': '.$lead->subject() : '').'.'])->forceFill(['created_at' => $created])->saveQuietly();

        if ($status !== LeadStatus::New) {
            $replied = $created->copy()->addMinutes(mt_rand(25, 60 * 20));
            if ($replied->isFuture()) {
                $replied = now()->subMinutes(5);
            }
            $lead->forceFill(['status' => $status, 'assigned_to' => $assignee->id, 'first_contacted_at' => $replied, 'status_changed_at' => $replied])->saveQuietly();
            $lead->notes()->create(['user_id' => $assignee->id, 'kind' => 'note', 'body' => match ($type) {
                LeadType::Tour => 'Emailed the guest to confirm the time and directions.',
                LeadType::Trade => 'Replied with the export spec sheet and asked about their market.',
                LeadType::Application => 'Acknowledged by email. CV reviewed.',
                LeadType::Enquiry => 'Replied by email.',
            }])->forceFill(['created_at' => $replied])->saveQuietly();
            $lead->notes()->create(['user_id' => $assignee->id, 'kind' => 'status', 'body' => 'Status changed to '.$status->label().'.'])->forceFill(['created_at' => $replied])->saveQuietly();
        }

        return $lead;
    }

    /** @return list<string> */
    private function timesOn(Carbon $day): array
    {
        if ($day->gt(today())) {
            return Tours::times($day);
        }

        // Past days: the same weekday schedule (closed dates included, it's sample history).
        return array_values((array) config('gdl.tours.slots.'.$day->dayOfWeekIso, []));
    }

    /** A one-page PDF reading "Sample CV", so the download works in the demo. */
    private function samplePdf(string $name): string
    {
        $text = 'Sample CV for the demo: '.preg_replace('/[^A-Za-z .\-]/', '', $name);
        $stream = "BT /F1 18 Tf 72 720 Td ({$text}) Tj ET";
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Kids [3 0 R] /Count 1 >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>',
            '<< /Length '.strlen($stream)." >>\nstream\n{$stream}\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];
        $pdf = "%PDF-1.4\n";
        $offsets = [];
        foreach ($objects as $i => $o) {
            $offsets[] = strlen($pdf);
            $pdf .= ($i + 1)." 0 obj\n{$o}\nendobj\n";
        }
        $xref = strlen($pdf);
        $pdf .= 'xref
0 '.(count($objects) + 1)."\n0000000000 65535 f \n";
        foreach ($offsets as $off) {
            $pdf .= sprintf("%010d 00000 n \n", $off);
        }

        return $pdf.'trailer << /Size '.(count($objects) + 1)." /Root 1 0 R >>\nstartxref\n{$xref}\n%%EOF\n";
    }
}
