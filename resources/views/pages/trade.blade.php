@php($t = gdl('trade.page'))
<x-layouts.site title="Trade & export enquiries" description="Import, distribute or stock Clarke's Court rum. Send a trade or export enquiry to Grenada Distillers and get a reference number straight away.">
    <x-page-header photo="{{ $t['photo'] }}" no="E" label="Trade & export" title="Bring Clarke's Court to your market." :lead="$t['lead']">
        <p class="mt-7"><a href="#enquire" class="btn btn-accent">Send a trade enquiry<x-icon name="arrow-right" class="nudge h-4 w-4" /></a></p>
    </x-page-header>

    <section class="wrap mt-14 grid gap-10 md:mt-20 lg:grid-cols-3">
        @foreach ($t['points'] as $i => $p)
            <div class="border-t-2 border-ink pt-5">
                <x-icon :name="$p['icon']" class="h-7 w-7 text-accent-text" />
                <h2 class="mt-4 font-sans text-xl font-bold">{{ $p['title'] }}</h2>
                <p class="mt-2 text-ink-2">{{ $p['text'] }}</p>
                @if (! empty($p['link']))<p class="mt-3"><a class="text-link" href="{{ $p['link']['url'] }}" rel="noopener" target="_blank">{{ $p['link']['label'] }}</a></p>@endif
            </div>
        @endforeach
    </section>

    <section id="enquire" class="wrap mt-20 scroll-mt-28 md:mt-28">
        <div class="grid gap-12 lg:grid-cols-[1fr_1.6fr] lg:gap-16">
            <div>
                <x-stamp no="1">Enquire</x-stamp>
                <h2 class="display-2 mt-5">Tell us about your business</h2>
                <p class="mt-4 measure text-ink-2">The more we know about your market, the faster our export team can answer with the right range, case formats and paperwork. You'll get a reference number as soon as you send it.</p>
                <div class="label-frame mt-8 p-6">
                    <h3 class="font-sans font-bold">What happens next</h3>
                    <ol class="mt-3 space-y-2 text-[0.9375rem] text-ink-2">
                        <li class="flex gap-3"><span class="font-display text-lg text-accent-text">1</span>We email you a reference straight away.</li>
                        <li class="flex gap-3"><span class="font-display text-lg text-accent-text">2</span>The export team replies, usually within two working days.</li>
                        <li class="flex gap-3"><span class="font-display text-lg text-accent-text">3</span>We agree samples, specifications and terms with you.</li>
                    </ol>
                </div>
            </div>

            <form method="POST" action="{{ route('trade.store') }}" class="space-y-12" x-data="leadForm" @submit="submit">
                @csrf
                <x-form-errors />
                <fieldset class="space-y-5">
                    <legend class="fieldset-title mb-5"><span class="step">1</span>Your company</legend>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-field name="organisation" label="Company name" :required="true" maxlength="160" autocomplete="organization" />
                        <x-field name="country" label="Country" :required="true" maxlength="80" autocomplete="country-name" />
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-select name="business_type" label="Type of business" :options="gdl('trade.business_types')" :required="true" />
                        <x-field name="job_title" label="Your job title" :optional="true" maxlength="120" autocomplete="organization-title" />
                    </div>
                    <x-field name="markets" label="Markets or channels you serve" :optional="true" maxlength="300" hint="For example: Ontario liquor boards, UK independents, Caribbean duty-free." />
                    <x-field name="company_site" label="Company website" type="url" :optional="true" maxlength="255" placeholder="https://" />
                </fieldset>

                <fieldset class="space-y-5">
                    <legend class="fieldset-title mb-5"><span class="step">2</span>What you're interested in</legend>
                    <div>
                        <p class="label" id="products-label">Rums <span class="opt">(optional, choose any)</span></p>
                        <div class="grid gap-2 sm:grid-cols-2" role="group" aria-labelledby="products-label">
                            @foreach ($products as $k => $name)
                                <label class="choice"><input type="checkbox" name="products[]" value="{{ $k }}" @checked(in_array($k, (array) old('products', []), true))>{{ $name }}</label>
                            @endforeach
                        </div>
                        <x-error for="products" />
                    </div>
                    <div>
                        <p class="label" id="volume-label">First order</p>
                        <div class="grid gap-2 sm:grid-cols-2" role="radiogroup" aria-labelledby="volume-label">
                            @foreach (gdl('trade.volumes') as $k => $label)
                                <label class="choice"><input type="radio" name="volume" value="{{ $k }}" required @checked(old('volume') === $k)>{{ $label }}</label>
                            @endforeach
                        </div>
                        <x-error for="volume" />
                    </div>
                    <div>
                        <p class="label" id="licensed-label">Do you hold an import or alcohol licence for your market?</p>
                        <div class="grid gap-2 sm:grid-cols-3" role="radiogroup" aria-labelledby="licensed-label">
                            @foreach (['yes' => 'Yes', 'in_progress' => 'Applying', 'no' => 'No'] as $k => $label)
                                <label class="choice"><input type="radio" name="licensed" value="{{ $k }}" required @checked(old('licensed') === $k)>{{ $label }}</label>
                            @endforeach
                        </div>
                        <x-error for="licensed" />
                    </div>
                    <x-field name="message" label="Your enquiry" type="textarea" :required="true" maxlength="3000" rows="5" hint="Volumes, formats, timing and anything else that helps." />
                </fieldset>

                <x-contact-fields :step="3" title="Who should we reply to?" email-hint="We email your reference and our reply here." />
                <div>
                    <x-submit label="Send trade enquiry" />
                    <p class="mt-4 text-sm text-ink-3">We use your details only to answer this enquiry. See our <a class="text-link" href="{{ route('privacy') }}">privacy notice</a>.</p>
                </div>
            </form>
        </div>
    </section>
</x-layouts.site>
