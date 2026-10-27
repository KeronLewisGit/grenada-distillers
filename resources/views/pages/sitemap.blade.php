<x-layouts.site title="Site map" description="Every page on the Clarke's Court website.">
    <x-page-header title="Site map" no="↦" label="All pages" photo="casks" />
    <section class="wrap mt-12 grid gap-10 md:mt-16 md:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            'Visit & taste' => ['Home' => route('home'), 'The rum range' => route('rums.index'), 'Heritage' => route('heritage'), 'Distillery tours' => route('tours')],
            'Work with us' => ['Trade & export enquiries' => route('trade'), 'Careers' => route('careers.index'), 'Send your CV' => route('careers.apply')],
            'Company' => ['Contact & directions' => route('contact'), 'Privacy notice' => route('privacy'), 'Photo credits' => route('credits')],
        ] as $group => $links)
            <div>
                <h2 class="font-sans text-lg font-bold">{{ $group }}</h2>
                <ul class="mt-3 space-y-1">@foreach ($links as $t => $u)<li><a class="text-link inline-flex min-h-11 items-center" href="{{ $u }}">{{ $t }}</a></li>@endforeach</ul>
            </div>
        @endforeach
        <div>
            <h2 class="font-sans text-lg font-bold">The rums</h2>
            <ul class="mt-3 space-y-1">@foreach (\App\Support\Rums::all() as $k => $r)<li><a class="text-link inline-flex min-h-11 items-center" href="{{ route('rums.show', $k) }}">{{ $r['name'] }}</a></li>@endforeach</ul>
        </div>
        @if ($jobs->isNotEmpty())
            <div class="md:col-span-2">
                <h2 class="font-sans text-lg font-bold">Vacancies</h2>
                <ul class="mt-3 space-y-1">@foreach ($jobs as $j)<li><a class="text-link inline-flex min-h-11 items-center" href="{{ route('careers.show', $j) }}">{{ $j->title }}</a></li>@endforeach</ul>
            </div>
        @endif
    </section>
</x-layouts.site>
