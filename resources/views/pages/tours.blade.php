@php
    $weeks = collect($grid)->groupBy(fn (array $d) => $d['date']->copy()->startOfWeek()->toDateString());
    $oldSlot = old_string('slot');
    // Reopen the week of the slot that was chosen before a validation error (only if it is still on the grid).
    $oldDay = collect($grid)->first(fn (array $d) => $d['date']->toDateString() === substr($oldSlot, 0, 10));
    $openWeek = $oldDay ? $oldDay['date']->copy()->startOfWeek()->toDateString() : $weeks->keys()->first();
    $tour = gdl('tours.about');
@endphp
<x-layouts.site title="Distillery tours" description="Book a guided tour of the Clarke's Court distillery at Woodlands, St George, Grenada. Choose a day and time and get a reference straight away.">
    <x-page-header photo="{{ gdl('tours.photo', 'mill') }}" no="T" label="Distillery tours" title="See where Grenada's rum is made."
        :lead="$tour['lead']">
        <p class="mt-7 flex flex-wrap gap-3"><a href="#book" class="btn btn-accent">Choose a tour time<x-icon name="arrow-right" class="nudge h-4 w-4" /></a><a href="{{ route('contact') }}#directions" class="btn btn-on-dark">Directions to Woodlands</a></p>
    </x-page-header>

    <section class="wrap mt-14 grid gap-12 md:mt-20 lg:grid-cols-[1.1fr_1fr] lg:gap-16">
        <div>
            <x-stamp no="1">On the tour</x-stamp>
            <h2 class="display-3 mt-5">{{ $tour['heading'] }}</h2>
            <ul class="ledger mt-8">
                @foreach ($tour['stops'] as $i => $stop)
                    <li><span class="yr">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span><div><h3 class="text-lg font-bold">{{ $stop['title'] }}</h3><p class="mt-1 text-ink-2">{{ $stop['text'] }}</p></div></li>
                @endforeach
            </ul>
        </div>
        <aside class="space-y-5">
            <x-photo :key="$tour['side_photo']" :alt="$tour['side_alt']" sizes="(min-width: 1024px) 40vw, 100vw" class="aspect-[4/3] rounded-md" />
            <div class="label-frame p-6 md:p-8">
                <h2 class="font-sans text-lg font-bold">Good to know</h2>
                <x-spec class="mt-3" :rows="[
                    'Tour days' => $tour['days_text'],
                    'Places per tour' => $capacity.' guests',
                    'Book online for' => 'Up to '.$maxParty.' people',
                    'Tasting' => 'Adults '.gdl('legal_age').'+ only',
                    'Where' => gdl('address.locality').', '.gdl('address.parish'),
                ]" />
                <p class="mt-4 text-[0.9375rem] text-ink-2">Bigger group, cruise excursion or school visit? <a class="text-link" href="{{ route('contact') }}?topic=tour_group">Ask us about a group tour</a>.</p>
            </div>
        </aside>
    </section>

    <section id="book" class="wrap mt-20 scroll-mt-28 md:mt-28">
        <div class="max-w-3xl">
            <x-stamp no="2">Book</x-stamp>
            <h2 class="display-2 mt-5">Choose a day and a time</h2>
            <p class="lead mt-4 text-ink-2">Each tour takes {{ $capacity }} guests. The places left are shown under every time, and your places are held as soon as you send the form.</p>
        </div>

        <form method="POST" action="{{ route('tours.store') }}" class="mt-10 grid gap-12 lg:grid-cols-[1.35fr_1fr]" x-data="leadForm" @submit="submit">
            @csrf
            <x-form-errors />
            <fieldset class="lg:row-span-2">
                <legend class="fieldset-title mb-5"><span class="step">1</span>Tour day and time</legend>
                <x-error for="slot" />
                @if ($grid === [])
                    <p class="panel p-6">There are no tours open for booking right now. Please <a class="text-link" href="{{ route('contact') }}">contact us</a>.</p>
                @endif
                <div class="space-y-3">
                    @foreach ($weeks as $week => $days)
                        @php($free = collect($days)->sum(fn ($d) => array_sum($d['slots'])))
                        <details class="panel group" @if ($week === $openWeek) open @endif>
                            <summary class="flex min-h-14 cursor-pointer list-none items-center gap-3 px-5 py-3 font-semibold [&::-webkit-details-marker]:hidden">
                                <x-icon name="calendar" class="h-5 w-5 flex-none text-accent-text" />
                                <span>Week of {{ \Illuminate\Support\Carbon::parse($week)->format('j F') }}</span>
                                <span class="ml-auto text-sm font-normal text-ink-3">{{ $free > 0 ? $free.' places' : 'Fully booked' }}</span>
                                <x-icon name="chevron-down" class="h-4 w-4 flex-none transition-transform group-open:rotate-180" />
                            </summary>
                            <div class="border-t border-line px-5 pb-2">
                                @foreach ($days as $d)
                                    <div class="slot-day py-4">
                                        <p class="font-display text-xl">{{ $d['date']->format('l j F') }}</p>
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            @foreach ($d['slots'] as $time => $left)
                                                @php($value = $d['date']->toDateString().' '.$time)
                                                <label class="choice slot" data-full="{{ $left === 0 ? 'true' : 'false' }}">
                                                    <input type="radio" name="slot" value="{{ $value }}" required @checked($oldSlot === $value) @disabled($left === 0)>
                                                    <span class="t">{{ \App\Support\Tours::label($time) }}</span>
                                                    <span class="left">{{ $left === 0 ? 'Full' : ($left === 1 ? '1 place left' : $left.' places left') }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    @endforeach
                </div>
            </fieldset>

            <div class="space-y-12">
                <fieldset class="space-y-5">
                    <legend class="fieldset-title mb-5"><span class="step">2</span>Your party</legend>
                    <div class="grid grid-cols-2 gap-4">
                        <x-field name="adults" label="Adults" type="number" :required="true" min="1" :max="$maxParty" :value="1" inputmode="numeric" />
                        <x-field name="children" label="Under 18" type="number" min="0" :max="$maxParty" :value="0" inputmode="numeric" hint="No tasting." />
                    </div>
                    <x-select name="group_type" label="Who is coming?" :options="gdl('tours.group_types')" :required="true" />
                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-field name="country" label="Country you live in" :optional="true" maxlength="80" autocomplete="country-name" />
                        <x-field name="staying" label="Staying at" :optional="true" maxlength="120" hint="Hotel, villa or ship." />
                    </div>
                    <x-field name="access" label="Access needs" type="textarea" :optional="true" maxlength="500" rows="2" hint="Tell us if anyone needs step-free access or a seat." />
                </fieldset>
                <x-contact-fields :step="3" email-hint="We email your booking and reference here." />
                <div>
                    <x-field name="message" label="Anything else?" type="textarea" :optional="true" maxlength="1000" rows="3" />
                    <div class="mt-6"><x-submit label="Book my places" /></div>
                    <p class="mt-4 text-sm text-ink-3">Under-18s are welcome on the tour but cannot take part in the tasting. By booking you accept our <a class="text-link" href="{{ route('privacy') }}">privacy notice</a>.</p>
                </div>
            </div>
        </form>
    </section>
</x-layouts.site>
