<x-layouts.site title="The rum range" description="The Clarke's Court rum range from Grenada Distillers: aged and dark rums, white and overproof rums, and flavoured rums and liqueurs.">
    <x-page-header photo="{{ gdl('range.photo') }}" no="R" label="The range" title="The Clarke's Court range" :lead="gdl('range.lead')">
        <nav class="mt-7 flex flex-wrap gap-2" aria-label="Rum families">
            @foreach ($families as $family => $rums)
                <a href="#{{ $family }}" class="tag">{{ gdl('families.'.$family.'.label') }}</a>
            @endforeach
        </nav>
    </x-page-header>

    @foreach ($families as $family => $rums)
        <section id="{{ $family }}" class="wrap mt-16 scroll-mt-28 md:mt-24" aria-labelledby="fam-{{ $family }}">
            <div class="grid gap-4 md:grid-cols-[1fr_1.4fr] md:items-end">
                <div>
                    <x-stamp :no="$loop->iteration">{{ gdl('families.'.$family.'.label') }}</x-stamp>
                    <h2 id="fam-{{ $family }}" class="display-2 mt-5">{{ gdl('families.'.$family.'.title') }}</h2>
                </div>
                <p class="measure text-ink-2">{{ gdl('families.'.$family.'.blurb') }}</p>
            </div>
            <ul class="shelf mt-10 grid grid-cols-2 gap-x-4 gap-y-10 pb-8 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($rums as $key => $rum)
                    @include('pages.rums.card', ['key' => $key, 'rum' => $rum])
                @endforeach
            </ul>
        </section>
    @endforeach

    <section class="wrap mt-20 md:mt-28">
        <div class="label-frame grid gap-6 p-6 md:grid-cols-[1fr_auto] md:items-center md:p-10">
            <div>
                <h2 class="display-3">Stocking Clarke's Court?</h2>
                <p class="mt-2 measure text-ink-2">Importers, distributors, duty-free and bars can ask the export team for specifications, case formats and samples.</p>
            </div>
            <a href="{{ route('trade') }}#enquire" class="btn btn-accent">Send a trade enquiry<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        </div>
    </section>
</x-layouts.site>
