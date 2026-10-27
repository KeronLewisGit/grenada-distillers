@php
    $open = $job->isOpen();
    $ld = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'JobPosting',
        'title' => $job->title,
        'description' => e($job->summary).($job->duties ? '<ul><li>'.implode('</li><li>', array_map('e', $job->lines('duties'))).'</li></ul>' : ''),
        'datePosted' => $job->created_at->toDateString(),
        'validThrough' => $job->closes_on?->toDateString(),
        'employmentType' => $job->employment_type->schema(),
        'hiringOrganization' => ['@type' => 'Organization', 'name' => gdl('name'), 'sameAs' => route('home')],
        'jobLocation' => ['@type' => 'Place', 'address' => ['@type' => 'PostalAddress', 'addressLocality' => gdl('address.locality'), 'addressRegion' => gdl('address.parish'), 'addressCountry' => 'GD']],
    ]);
@endphp
<x-layouts.site :title="$job->title.' · Careers'" :description="$job->summary" :json-ld="$open ? [$ld] : []">
    <x-page-header photo="{{ gdl('careers.photo') }}" no="C" :label="$job->department" :title="$job->title" :lead="$job->summary">
        <p class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-white/85">
            <span class="inline-flex items-center gap-2"><x-icon name="map-pin" class="h-4 w-4 text-accent" />{{ $job->location }}</span>
            <span class="inline-flex items-center gap-2"><x-icon name="briefcase" class="h-4 w-4 text-accent" />{{ $job->employment_type->label() }}</span>
            <span class="inline-flex items-center gap-2"><x-icon name="calendar" class="h-4 w-4 text-accent" />{{ $job->closes_on ? 'Closes '.$job->closes_on->format('j F Y') : 'Open until filled' }}</span>
        </p>
    </x-page-header>

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[1.6fr_1fr] lg:gap-16">
        <article class="prose-copy measure text-ink-2">
            <p><a href="{{ route('careers.index') }}" class="text-link">All vacancies</a></p>
            @if ($job->is_demo)<p><span class="demo-badge">Sample posting</span> Based on a vacancy Grenada Distillers advertised; the details are illustrative.</p>@endif
            @if ($job->duties)
                <h2>What you'll do</h2>
                <ul>@foreach ($job->lines('duties') as $line)<li>{{ $line }}</li>@endforeach</ul>
            @endif
            @if ($job->requirements)
                <h2>What we're looking for</h2>
                <ul>@foreach ($job->lines('requirements') as $line)<li>{{ $line }}</li>@endforeach</ul>
            @endif
        </article>
        <aside>
            <div class="label-frame p-6 md:p-8 lg:sticky lg:top-28">
                @if ($open)
                    <h2 class="font-sans text-lg font-bold">Apply for this role</h2>
                    <p class="mt-2 text-ink-2">Have your CV ready as a PDF or Word file. It takes about five minutes.</p>
                    <a href="{{ route('careers.apply', ['job' => $job->slug]) }}" class="btn btn-accent mt-5 w-full">Apply now<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
                @else
                    <h2 class="font-sans text-lg font-bold">This vacancy is closed</h2>
                    <p class="mt-2 text-ink-2">We are no longer taking applications for this role. You can still send a general application.</p>
                    <a href="{{ route('careers.apply') }}" class="btn btn-primary mt-5 w-full">Send a general application</a>
                @endif
            </div>
        </aside>
    </div>
</x-layouts.site>
