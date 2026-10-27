@php($home = gdl('home'))
<x-layouts.site :description="gdl('description')">
    {{-- Home hero: the one page that does not use <x-page-header>, by design. --}}
    <section class="relative isolate overflow-hidden bg-molasses-950 text-white on-dark">
        <div class="hero-photo absolute inset-0 -z-10">
            <x-photo key="hero" :alt="$home['hero_alt']" :eager="true" sizes="100vw" class="h-full w-full" :position="gdl('photos.hero.position', 'center')" />
            <div class="hero-scrim absolute inset-0"></div>
        </div>
        <div class="wrap flex min-h-[34rem] flex-col justify-end pb-14 pt-24 md:min-h-[40rem] md:pb-20 lg:min-h-[44rem]">
            <x-stamp no="{{ gdl('founded') }}" :dark="true">Woodlands · Grenada</x-stamp>
            <h1 class="display-1 mt-6 max-w-4xl">{{ $home['title'] }}</h1>
            <p class="lead mt-5 text-white/85">{{ $home['lead'] }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('rums.index') }}" class="btn btn-accent">Explore the rums<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
                <a href="{{ route('tours') }}#book" class="btn btn-on-dark">Book a distillery tour</a>
            </div>
        </div>
        <div class="hoops" aria-hidden="true"></div>
    </section>

    {{-- Three doors: the three things the old site had nowhere to send. --}}
    <section class="wrap -mt-px pt-14 md:pt-20" aria-label="What brings you here">
        <ul class="grid gap-5 md:grid-cols-3">
            @foreach ([
                ['ticket', 'Visit the distillery', $nextTour ? 'Next tour with places: '.$nextTour['date']->format('l j F').'.' : 'Guided tours with a tasting for adults.', route('tours').'#book', 'Book a tour'],
                ['ship', 'Trade & export', 'Importers, distributors, duty-free and bars: ask the export team.', route('trade').'#enquire', 'Send an enquiry'],
                ['briefcase', 'Careers', $openJobs > 0 ? $openJobs.' '.\Illuminate\Support\Str::plural('vacancy', $openJobs).' open at Woodlands now.' : 'Send HR your CV for future roles.', route('careers.index'), 'See vacancies'],
            ] as [$icon, $title, $text, $url, $cta])
                <li class="card-link label-frame flex flex-col p-6 md:p-7" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms">
                    <x-icon :name="$icon" class="h-7 w-7 text-accent-text" />
                    <h2 class="font-display mt-4 text-[1.75rem] leading-tight">{{ $title }}</h2>
                    <p class="mt-2 text-ink-2">{{ $text }}</p>
                    <p class="mt-auto pt-5"><a href="{{ $url }}" class="stretch inline-flex min-h-11 items-center gap-2 font-bold text-accent-text">{{ $cta }}<x-icon name="arrow-right" class="h-4 w-4" /></a></p>
                </li>
            @endforeach
        </ul>
    </section>

    {{-- The shelf --}}
    <section class="wrap mt-20 md:mt-28" aria-labelledby="range-title">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <x-stamp no="R">The range</x-stamp>
                <h2 id="range-title" class="display-2 mt-5">{{ $home['range_title'] }}</h2>
            </div>
            <a href="{{ route('rums.index') }}" class="btn btn-outline">See every rum</a>
        </div>
        <ul class="shelf mt-10 grid grid-cols-2 gap-x-4 gap-y-10 pb-8 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($home['featured'] as $key)
                @if ($rum = \App\Support\Rums::get($key))
                    @include('pages.rums.card', ['key' => $key, 'rum' => $rum])
                @endif
            @endforeach
        </ul>
    </section>

    {{-- Heritage band --}}
    <section class="relative isolate mt-20 overflow-hidden bg-molasses-900 text-white on-dark md:mt-28">
        <div class="wrap grid gap-10 py-16 md:grid-cols-2 md:items-center md:py-24">
            <div>
                <x-stamp no="{{ gdl('founded') }}" :dark="true">Heritage</x-stamp>
                <h2 class="display-2 mt-5">{{ $home['heritage_title'] }}</h2>
                <p class="lead mt-5 text-white/85">{{ $home['heritage_text'] }}</p>
                <p class="mt-8"><a href="{{ route('heritage') }}" class="btn btn-on-dark">Read the story<x-icon name="arrow-right" class="nudge h-4 w-4" /></a></p>
            </div>
            <x-photo :key="$home['heritage_photo']" :alt="$home['heritage_alt']" sizes="(min-width: 768px) 45vw, 100vw" class="aspect-[4/3] rounded-md ring-1 ring-accent/40" />
        </div>
        <div class="ribbon" aria-hidden="true"></div>
    </section>

    {{-- Tours teaser --}}
    <section class="wrap mt-20 grid gap-10 md:mt-28 md:grid-cols-[1fr_1.1fr] md:items-center">
        <x-photo :key="$home['tour_photo']" :alt="$home['tour_alt']" sizes="(min-width: 768px) 45vw, 100vw" class="aspect-[4/3] rounded-md" />
        <div>
            <x-stamp no="T">Tours</x-stamp>
            <h2 class="display-2 mt-5">{{ $home['tour_title'] }}</h2>
            <p class="mt-4 measure text-ink-2">{{ $home['tour_text'] }}</p>
            @if ($nextTour)
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach (array_filter($nextTour['slots']) as $time => $left)
                        <a href="{{ route('tours') }}#book" class="tag"><span class="num">{{ \App\Support\Tours::label($time) }}</span><span class="text-ink-3">{{ $left }} left</span></a>
                    @endforeach
                </div>
                <p class="mt-2 text-sm text-ink-3">Places on {{ $nextTour['date']->format('l j F') }}</p>
            @endif
            <p class="mt-7"><a href="{{ route('tours') }}#book" class="btn btn-accent">Book your places<x-icon name="arrow-right" class="nudge h-4 w-4" /></a></p>
        </div>
    </section>

    {{-- Export band --}}
    <section class="wrap mt-20 md:mt-28">
        <div class="label-frame grid gap-8 p-6 md:grid-cols-[1.3fr_1fr] md:items-center md:p-12">
            <div>
                <x-stamp no="E">Export</x-stamp>
                <h2 class="display-3 mt-5">{{ $home['export_title'] }}</h2>
                <p class="mt-3 measure text-ink-2">{{ $home['export_text'] }}</p>
            </div>
            <div class="flex flex-col gap-3 md:items-end">
                <a href="{{ route('trade') }}#enquire" class="btn btn-primary">Send a trade enquiry</a>
                <a href="{{ route('contact') }}?topic=where_to_buy" class="btn btn-outline">Where can I buy it?</a>
            </div>
        </div>
    </section>
</x-layouts.site>
