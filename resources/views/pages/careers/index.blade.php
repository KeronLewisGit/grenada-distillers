<x-layouts.site title="Careers" description="Work at Grenada Distillers, the home of Clarke's Court rum, at Woodlands, St George. See open vacancies and apply online with your CV.">
    <x-page-header photo="{{ gdl('careers.photo') }}" no="C" label="Careers" title="Work at the distillery." :lead="gdl('careers.lead')">
        <p class="mt-7 flex flex-wrap gap-3"><a href="#vacancies" class="btn btn-accent">See the vacancies<x-icon name="arrow-right" class="nudge h-4 w-4" /></a><a href="{{ route('careers.apply') }}" class="btn btn-on-dark">Send a general application</a></p>
    </x-page-header>

    <section id="vacancies" class="wrap mt-14 scroll-mt-28 md:mt-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <x-stamp :no="$jobs->count()">Open now</x-stamp>
                <h2 class="display-2 mt-5">Current vacancies</h2>
            </div>
            <p class="text-ink-3">All roles are based at {{ gdl('address.locality') }}, {{ gdl('address.parish') }}.</p>
        </div>

        @if ($jobs->isEmpty())
            <div class="label-frame mt-10 max-w-2xl p-8">
                <h3 class="font-sans text-lg font-bold">No vacancies are open right now</h3>
                <p class="mt-2 text-ink-2">You can still send us your CV. HR keeps general applications for twelve months and contacts you if a suitable role opens.</p>
                <p class="mt-5"><a href="{{ route('careers.apply') }}" class="btn btn-primary">Send your CV</a></p>
            </div>
        @else
            <ul class="mt-10 grid gap-5 md:grid-cols-2">
                @foreach ($jobs as $job)
                    <li class="card-link label-frame flex flex-col p-6 md:p-8">
                        <p class="kicker flex flex-wrap items-center gap-3 text-ink-3">{{ $job->department }}@if ($job->is_demo)<span class="demo-badge">Sample</span>@endif</p>
                        <h3 class="font-display mt-3 text-[1.75rem] leading-tight"><a class="stretch" href="{{ route('careers.show', $job) }}">{{ $job->title }}</a></h3>
                        <p class="mt-3 text-ink-2">{{ $job->summary }}</p>
                        <p class="mt-auto flex flex-wrap gap-x-5 gap-y-1 pt-5 text-[0.9375rem] text-ink-3">
                            <span class="inline-flex items-center gap-1.5"><x-icon name="briefcase" class="h-4 w-4" />{{ $job->employment_type->label() }}</span>
                            <span class="inline-flex items-center gap-1.5"><x-icon name="calendar" class="h-4 w-4" />{{ $job->closes_on ? 'Closes '.$job->closes_on->format('j F Y') : 'Open until filled' }}</span>
                        </p>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="wrap mt-20 grid gap-10 md:mt-28 lg:grid-cols-[1fr_1fr] lg:items-center">
        <x-photo :key="gdl('careers.side_photo')" :alt="gdl('careers.side_alt')" sizes="(min-width: 1024px) 45vw, 100vw" class="aspect-[4/3] rounded-md" />
        <div>
            <x-stamp no="?">How to apply</x-stamp>
            <h2 class="display-3 mt-5">Apply online in about five minutes</h2>
            <ol class="ledger mt-6">
                <li><span class="yr">01</span><p>Choose a vacancy, or send a general application if nothing fits yet.</p></li>
                <li><span class="yr">02</span><p>Tell us about your experience and attach your CV as a PDF or Word file (up to 5 MB).</p></li>
                <li><span class="yr">03</span><p>You get a reference number by email. Only our HR team can open your CV.</p></li>
            </ol>
        </div>
    </section>
</x-layouts.site>
