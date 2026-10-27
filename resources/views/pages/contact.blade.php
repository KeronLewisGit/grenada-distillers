@php
    $topics = gdl('enquiry_topics');
    $topic = old('topic', array_key_exists((string) request('topic'), $topics) ? request('topic') : 'general');
    $address = gdl('address');
@endphp
<x-layouts.site title="Contact & directions" :description="'Grenada Distillers Ltd, '.$address['locality'].', '.$address['parish'].', Grenada. '.gdl('email').'. '.\App\Support\Hours::summary().'.'">
    <x-page-header photo="{{ gdl('contact_photo') }}" no="@" label="Contact" title="Contact Clarke's Court" lead="Send a message and the right team will reply by email during office hours. Booking a tour, buying for trade or applying for a job? Use the forms made for them, so nothing waits in the wrong inbox." />

    <div class="wrap mt-12 grid gap-12 md:mt-16 lg:grid-cols-[1fr_1.3fr] lg:gap-16">
        <div class="space-y-10">
            <section aria-labelledby="routes-title">
                <h2 id="routes-title" class="display-3">The fastest route</h2>
                <ul class="mt-5 grid gap-3">
                    @foreach ([
                        ['ticket', 'Book a distillery tour', route('tours').'#book', 'Pick a time and get a reference straight away.'],
                        ['ship', 'Trade & export enquiries', route('trade').'#enquire', 'Importers, distributors, duty-free and the on-trade.'],
                        ['briefcase', 'Jobs and CVs', route('careers.index'), 'Open vacancies and general applications.'],
                    ] as [$icon, $label, $url, $note])
                        <li class="card-link panel flex items-start gap-4 p-5">
                            <x-icon :name="$icon" class="mt-0.5 h-6 w-6 flex-none text-accent-text" />
                            <div><a href="{{ $url }}" class="stretch font-semibold">{{ $label }}</a><p class="text-[0.9375rem] text-ink-3">{{ $note }}</p></div>
                            <x-icon name="arrow-right" class="ml-auto mt-1 h-4 w-4 flex-none" />
                        </li>
                    @endforeach
                </ul>
            </section>
            <section aria-labelledby="dir-title">
                <h2 id="dir-title" class="display-3">Reach us</h2>
                <x-spec class="mt-5" :rows="array_filter([
                    'Email' => gdl('email'),
                    'Telephone' => gdl('phone') ? format_phone(gdl('phone')) : null,
                ])" />
                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <a href="mailto:{{ gdl('email') }}" class="btn btn-primary"><x-icon name="mail" class="h-4 w-4" />Email us</a>
                    @if (gdl('phone'))<a href="{{ tel_href(gdl('phone')) }}" class="btn btn-outline"><x-icon name="phone" class="h-4 w-4" />Call</a>@endif
                </div>
            </section>
            <section aria-labelledby="hours-title">
                <h2 id="hours-title" class="display-3">Office hours</h2>
                <x-spec class="mt-5" :rows="\App\Support\Hours::rows()" />
            </section>
            <section id="directions" aria-labelledby="addr-title" class="scroll-mt-28">
                <h2 id="addr-title" class="display-3">Finding the distillery</h2>
                <address class="mt-4 not-italic leading-relaxed text-ink-2">{{ gdl('name') }}<br>{{ $address['street'] }}, {{ $address['parish'] }}<br>{{ $address['country'] }}</address>
                <p class="mt-3 measure text-ink-2">{{ gdl('directions') }}</p>
                <a href="{{ gdl('map_url') }}" class="btn btn-outline mt-5" rel="noopener" target="_blank"><x-icon name="map-pin" class="h-4 w-4" />Open in Google Maps<span class="sr-only">(opens in a new tab)</span></a>
            </section>
        </div>

        <section aria-labelledby="msg-title">
            <div class="label-frame p-6 md:p-10">
                <h2 id="msg-title" class="display-3">Send a message</h2>
                <form method="POST" action="{{ route('contact.store') }}" class="mt-8 space-y-10" x-data="leadForm" @submit="submit">
                    @csrf
                    <x-form-errors />
                    <fieldset class="space-y-5">
                        <legend class="fieldset-title mb-5"><span class="step">1</span>Your message</legend>
                        <div>
                            <label for="f-topic" class="label">What is it about?</label>
                            <select id="f-topic" name="topic" class="input" required>
                                @foreach ($topics as $k => $label)<option value="{{ $k }}" @selected($topic === $k)>{{ $label }}</option>@endforeach
                            </select>
                            <x-error for="topic" />
                        </div>
                        <x-field name="message" label="Message" type="textarea" :required="true" maxlength="3000" rows="5" />
                        <x-field name="country" label="Country" :optional="true" maxlength="80" autocomplete="country-name" />
                    </fieldset>
                    <x-contact-fields :step="2" :phone-required="false" email-hint="We reply to this address." />
                    <div>
                        <x-submit label="Send message" />
                        <p class="mt-4 text-sm text-ink-3">See our <a class="text-link" href="{{ route('privacy') }}">privacy notice</a>.</p>
                    </div>
                </form>
            </div>
        </section>
    </div>
</x-layouts.site>
