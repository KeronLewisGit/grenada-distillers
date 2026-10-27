<x-layouts.site title="Photo credits" description="Licences and authors for the photographs used on this website.">
    <x-page-header title="Photo credits" :lead="gdl('credits_lead')" no="©" label="Credits" photo="casks" />
    <section class="wrap mt-12 md:mt-16">
        <p class="measure text-ink-2">Photos credited to Grenada Distillers or Clarke's Court are the company's own, taken from its earlier website and social media for this proposal. The others are from Wikimedia Commons and are used under the licences shown. Some show other distilleries or places in Grenada and should be replaced with the distillery's own photography before launch.</p>
        <ul class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (config('photo-credits') as $key => $c)
                <li class="panel overflow-hidden">
                    <x-photo :key="$key" :alt="$c['title']" sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, 100vw" class="aspect-[3/2]" />
                    <div class="p-5 text-[0.9375rem]">
                        <p class="font-semibold text-ink">{{ $c['title'] }}</p>
                        <p class="mt-1 text-ink-2">By {{ $c['author'] }}</p>
                        <p class="mt-1 text-ink-2">
                            @if ($c['license_url'])<a class="text-link" href="{{ $c['license_url'] }}" rel="license noopener" target="_blank">{{ $c['license'] }}</a>@else{{ $c['license'] }}@endif
                            · <a class="text-link" href="{{ $c['source'] }}" rel="noopener" target="_blank">Source</a>
                        </p>
                        @if (! empty($c['used_for']))<p class="mt-1 text-sm text-ink-3">Note: {{ $c['used_for'] }}</p>@endif
                    </div>
                </li>
            @endforeach
        </ul>
        <p class="mt-8 text-sm text-ink-3">Photos were resized and cropped for the web. CC BY-SA photos remain under their original licence.</p>
    </section>
</x-layouts.site>
