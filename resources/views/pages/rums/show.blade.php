@php
    $ld = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => "Clarke's Court ".$rum['name'],
        'brand' => ['@type' => 'Brand', 'name' => "Clarke's Court"],
        'manufacturer' => ['@type' => 'Organization', 'name' => gdl('name')],
        'category' => 'Rum',
        'description' => $rum['summary'],
        'image' => asset('img/'.$rum['photo'].'-960.webp'),
    ]);
@endphp
<x-layouts.site :title="$rum['name']" :description="\Illuminate\Support\Str::limit($rum['summary'], 155)" :json-ld="[$ld]" :og-image="$rum['photo']">
    <x-page-header photo="{{ gdl('families.'.$rum['family'].'.photo') }}" no="R" :label="gdl('families.'.$rum['family'].'.label')" :title="$rum['name']" :lead="$rum['summary']">
        <p class="mt-6"><a href="{{ route('rums.index') }}#{{ $rum['family'] }}" class="inline-flex min-h-11 items-center gap-2 font-semibold text-white/85 hover:text-white"><x-icon name="arrow-left" class="h-4 w-4" />The whole range</a></p>
    </x-page-header>

    <div class="wrap mt-12 grid gap-12 md:mt-16 md:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)] lg:gap-20">
        <div>
            @php($cover = ! empty($rum['cover']))
            <div class="bottle-tile label-frame relative flex aspect-[3/4] items-center justify-center overflow-hidden md:sticky md:top-28 {{ $cover ? '' : 'p-8' }}">
                <x-photo :key="$rum['photo']" :alt="$cover ? 'Nutmeg drying on wooden racks at a Grenada co-operative' : 'Bottle of Clarke\'s Court '.$rum['name']" sizes="(min-width: 768px) 35vw, 90vw" :class="$cover ? 'h-full w-full' : 'photo-contain h-full w-full !bg-transparent'" :eager="true" />
                @if (! empty($rum['abv']))<x-seal :abv="$rum['abv']" class="absolute right-4 top-4" />@endif
                @if ($cover)<p class="absolute inset-x-0 bottom-0 bg-molasses-950/80 px-4 py-2 text-sm text-white">Bottle photo to come from Grenada Distillers.</p>@endif
            </div>
        </div>
        <div>
            <x-stamp no="i">{{ $rum['style'] }}</x-stamp>
            <div class="prose-copy measure mt-6 text-ink-2">
                @foreach ((array) $rum['notes'] as $para)<p>{{ $para }}</p>@endforeach
            </div>
            <x-spec class="mt-8 max-w-xl" :rows="array_filter([
                'Style' => $rum['style'],
                'Strength' => ! empty($rum['abv']) ? $rum['abv'].'% ABV' : null,
                'Bottle sizes' => ! empty($rum['sizes']) ? implode(', ', $rum['sizes']) : null,
                'Made at' => 'Woodlands, St George, Grenada',
            ])" />
            @if (! empty($rum['serve']))
                <div class="mt-8 max-w-xl border-l-4 border-accent pl-5">
                    <p class="kicker text-ink-3">How it's served</p>
                    <p class="mt-1 text-ink-2">{{ $rum['serve'] }}</p>
                </div>
            @endif
            <div class="mt-10 flex flex-wrap gap-3">
                <a href="{{ route('trade') }}#enquire" class="btn btn-accent">Trade enquiry<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
                <a href="{{ route('tours') }}#book" class="btn btn-outline">Taste it on a tour</a>
            </div>
            <div class="mt-10 max-w-xl border-t border-line pt-5 text-sm text-ink-3">
                <p class="font-semibold text-ink-2">Sources for this page</p>
                <ul class="mt-1 space-y-1">
                    @foreach ($rum['sources'] as $s)<li><a class="text-link" href="{{ $s['url'] }}" rel="noopener" target="_blank">{{ $s['label'] }}</a></li>@endforeach
                </ul>
                <p class="mt-2">Strength and bottle sizes vary by market; check the label.</p>
            </div>
        </div>
    </div>

    @if ($related !== [])
        <section class="wrap mt-20 md:mt-28" aria-labelledby="more-title">
            <h2 id="more-title" class="display-3">More from the range</h2>
            <ul class="shelf mt-8 grid grid-cols-2 gap-x-4 gap-y-10 pb-8 sm:grid-cols-3">
                @foreach ($related as $k => $r)
                    @include('pages.rums.card', ['key' => $k, 'rum' => $r])
                @endforeach
            </ul>
        </section>
    @endif
</x-layouts.site>
