@php($h = gdl('heritage'))
<x-layouts.site title="Heritage" description="The story of Clarke's Court and Grenada Distillers: from the Woodlands sugar estate to Grenada's largest rum distillery, at work since 1937.">
    <x-page-header photo="{{ $h['photo'] }}" no="{{ gdl('founded') }}" label="Heritage" :title="$h['title']" :lead="$h['lead']" />

    <section class="wrap mt-14 grid gap-12 md:mt-20 lg:grid-cols-[1.25fr_1fr] lg:gap-16">
        <div class="prose-copy measure text-ink-2">
            @foreach ($h['story'] as $para)<p>{{ $para }}</p>@endforeach
        </div>
        <figure>
            <x-photo :key="$h['side_photo']" :alt="$h['side_alt']" sizes="(min-width: 1024px) 40vw, 100vw" class="aspect-[4/3] rounded-md" />
            <figcaption class="mt-3 text-sm text-ink-3">{{ $h['side_caption'] }}</figcaption>
        </figure>
    </section>

    <section class="wrap mt-20 md:mt-28" aria-labelledby="time-title">
        <x-stamp no="⧗">Timeline</x-stamp>
        <h2 id="time-title" class="display-2 mt-5">Milestones</h2>
        <ol class="ledger mt-10 max-w-4xl">
            @foreach ($h['timeline'] as $row)
                <li>
                    <span class="yr">{{ $row['year'] }}</span>
                    <div>
                        <h3 class="text-lg font-bold">{{ $row['title'] }}</h3>
                        <p class="mt-1 measure text-ink-2">{{ $row['text'] }}</p>
                        @php($sources = $row['sources'] ?? (empty($row['source']) ? [] : [$row['source']]))
                        @if ($sources)<p class="mt-1 text-sm text-ink-3">{{ count($sources) > 1 ? 'Sources' : 'Source' }}: @foreach ($sources as $src)<a class="text-link" href="{{ $src['url'] }}" rel="noopener" target="_blank">{{ $src['label'] }}</a>@if (! $loop->last); @endif @endforeach</p>@endif
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    @if (! empty($h['gallery']))
        <section class="wrap mt-20 md:mt-28" aria-label="Archive photographs">
            <ul class="grid gap-5 sm:grid-cols-2 lg:grid-cols-{{ min(4, count($h['gallery'])) }}">
                @foreach ($h['gallery'] as $g)
                    <li>
                        <x-photo :key="$g['photo']" :alt="$g['alt']" sizes="(min-width: 1024px) 25vw, (min-width: 640px) 45vw, 100vw" class="aspect-[4/3] rounded-md" />
                        <p class="mt-2 text-sm text-ink-3">{{ $g['caption'] }}</p>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <section class="wrap mt-20 md:mt-28">
        <div class="label-frame grid gap-6 p-6 md:grid-cols-[1fr_auto] md:items-center md:p-10">
            <div>
                <h2 class="display-3">See it for yourself</h2>
                <p class="mt-2 measure text-ink-2">The tour takes you through the distillery at Woodlands and ends with a tasting for adults.</p>
            </div>
            <a href="{{ route('tours') }}#book" class="btn btn-accent">Book a distillery tour<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
    </section>
</x-layouts.site>
