@props(['title' => null, 'description' => null, 'jsonLd' => [], 'mobileBar' => true, 'ogImage' => 'hero', 'chrome' => true])
@php
    $pageTitle = $title ? $title.' · '.gdl('short_name') : gdl('short_name').' · '.gdl('tagline');
    $metaDescription = $description ?? gdl('description');
    $phone = gdl('phone');
    $email = gdl('email');
    $address = gdl('address');
    $nav = [
        ['route' => 'rums.index', 'match' => 'rums.*', 'label' => 'The rums'],
        ['route' => 'heritage', 'match' => 'heritage', 'label' => 'Heritage'],
        ['route' => 'tours', 'match' => 'tours', 'label' => 'Tours'],
        ['route' => 'trade', 'match' => 'trade', 'label' => 'Trade & export'],
        ['route' => 'careers.index', 'match' => 'careers.*', 'label' => 'Careers'],
        ['route' => 'contact', 'match' => 'contact', 'label' => 'Contact'],
    ];
    $organization = array_filter([
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => gdl('name'),
        'alternateName' => gdl('short_name'),
        'url' => route('home'),
        'telephone' => $phone ? '+'.us_digits($phone) : null,
        'email' => $email,
        'foundingDate' => (string) gdl('founded'),
        'image' => asset('img/hero-1920.webp'),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $address['street'],
            'addressLocality' => $address['locality'],
            'addressRegion' => $address['parish'],
            'addressCountry' => $address['country_code'],
        ],
        'sameAs' => array_values(array_filter((array) gdl('social'))),
    ]);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    @if (gdl('preview'))
        <meta name="robots" content="noindex, nofollow">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ gdl('short_name') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ str_starts_with($ogImage, 'http') ? $ogImage : asset('img/'.$ogImage.'-1920.webp') }}">
    <meta property="og:locale" content="en_GD">
    <meta name="twitter:card" content="summary_large_image">
    @foreach (array_merge([$organization], $jsonLd) as $ld)
        <script type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
    @endforeach
</head>
<body class="min-h-screen overflow-x-clip {{ $mobileBar && $chrome ? 'pb-[5.25rem] lg:pb-0' : '' }}" x-data="{ menu: false }" @keydown.escape.window="menu = false">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-surface focus:px-4 focus:py-3 focus:shadow-md">Skip to content</a>

    @if (gdl('preview'))
        <div class="bg-accent text-sm text-accent-ink">
            <p class="wrap flex items-start gap-2 py-2.5"><x-icon name="alert" class="mt-0.5 h-4 w-4 flex-none" /><span><strong class="font-bold">Concept preview prepared for Grenada Distillers Ltd.</strong> This is not the official Clarke's Court website. Requests sent here do not reach the distillery.</span></p>
        </div>
    @endif

    @if ($chrome)
    <header class="sticky top-0 z-40 bg-molasses-900 text-white">
        <div class="wrap flex h-[4.5rem] items-center gap-2 min-[400px]:gap-3">
            <a href="{{ route('home') }}" class="mr-auto inline-flex min-h-11 flex-none items-center rounded" aria-label="Clarke's Court, Grenada Distillers, home"><x-logo tone="light" /></a>

            <nav class="hidden items-center lg:flex" aria-label="Main">
                @foreach ($nav as $item)
                    @php($current = request()->routeIs($item['match']))
                    <a href="{{ route($item['route']) }}" @class(['relative whitespace-nowrap px-2.5 py-2.5 text-[0.9375rem] font-semibold transition-colors xl:px-3.5', 'text-white' => $current, 'text-white/75 hover:text-white' => ! $current]) @if($current) aria-current="page" @endif>
                        {{ $item['label'] }}
                        @if ($current)<span class="absolute inset-x-2.5 -bottom-[0.95rem] h-[3px] bg-accent xl:inset-x-3.5" aria-hidden="true"></span>@endif
                    </a>
                @endforeach
            </nav>

            <button type="button" onclick="toggleTheme()" class="hidden h-11 w-11 flex-none items-center justify-center rounded-full text-white/75 hover:bg-white/10 hover:text-white sm:inline-flex" aria-label="Switch light or dark theme">
                <x-icon name="moon" class="h-5 w-5 dark-hide" /><x-icon name="sun" class="hidden h-5 w-5 dark-show" />
            </button>
            <a href="{{ route('tours') }}#book" class="btn btn-accent btn-sm hidden flex-none whitespace-nowrap lg:inline-flex">Book a tour<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
            <button type="button" class="inline-flex h-11 w-11 flex-none items-center justify-center rounded-full ring-1 ring-white/25 lg:hidden" @click="menu = !menu" :aria-expanded="menu.toString()" aria-controls="mobile-menu" aria-label="Menu">
                <x-icon name="menu" x-show="!menu" /><x-icon name="x" x-show="menu" x-cloak />
            </button>
        </div>
        <div class="ribbon" aria-hidden="true"></div>
        {{-- Without JavaScript the menu stays open under the header (it is hidden only once Alpine runs). --}}
        <div id="mobile-menu" class="border-t border-white/10 bg-molasses-900 lg:hidden" x-show="menu" x-cloak x-transition.opacity>
            <nav class="wrap flex flex-col py-3" aria-label="Mobile">
                <a href="{{ route('home') }}" class="font-display rounded px-1 py-2.5 text-2xl">Home</a>
                @foreach ($nav as $item)
                    <a href="{{ route($item['route']) }}" class="font-display rounded px-1 py-2.5 text-2xl" @if(request()->routeIs($item['match'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                @endforeach
                <div class="mt-3 grid gap-3 border-t border-white/10 pt-5 sm:grid-cols-2">
                    <a href="{{ route('tours') }}#book" class="btn btn-accent">Book a distillery tour</a>
                    <a href="mailto:{{ $email }}" class="btn btn-on-dark"><x-icon name="mail" class="h-4 w-4" />Email us</a>
                </div>
                <button type="button" onclick="toggleTheme()" class="mt-3 flex min-h-11 items-center gap-2 rounded px-1 text-left font-semibold text-white/75"><x-icon name="moon" class="h-5 w-5" />Switch light or dark theme</button>
            </nav>
        </div>
    </header>
    @endif

    <main id="main">
        {{ $slot }}
    </main>

    @if ($chrome)
    <footer class="mt-24 bg-molasses-950 text-white/75">
        <div class="hoops" aria-hidden="true"></div>
        <div class="wrap grid gap-12 py-16 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr]">
            <div>
                <x-logo tone="light" />
                <p class="mt-5 max-w-xs text-white/75">{{ gdl('footer_blurb') }}</p>
                <p class="mt-6"><a class="inline-flex min-h-11 items-center gap-2 font-semibold text-white hover:text-accent" href="mailto:{{ $email }}"><x-icon name="mail" class="h-4 w-4" />{{ $email }}</a></p>
                @if ($phone)<p><a href="{{ tel_href($phone) }}" class="inline-flex min-h-11 items-center gap-2 font-semibold text-white hover:text-accent"><x-icon name="phone" class="h-4 w-4" />{{ format_phone($phone) }}</a></p>@endif
                <p class="mt-2 flex gap-2">
                    @foreach (array_filter((array) gdl('social')) as $network => $url)
                        <a href="{{ $url }}" rel="noopener" target="_blank" class="inline-flex h-11 w-11 items-center justify-center rounded-full ring-1 ring-white/25 hover:bg-white/10 hover:text-white" aria-label="{{ ucfirst($network) }} (opens in a new tab)"><x-icon :name="$network" class="h-5 w-5" /></a>
                    @endforeach
                </p>
            </div>
            <div>
                <h2 class="kicker font-sans text-white/60">Visit &amp; taste</h2>
                <ul class="mt-4 space-y-1">
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('rums.index') }}">The rum range</a></li>
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('tours') }}">Distillery tours</a></li>
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('heritage') }}">Our heritage</a></li>
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('contact') }}">Contact &amp; directions</a></li>
                </ul>
            </div>
            <div>
                <h2 class="kicker font-sans text-white/60">Work with us</h2>
                <ul class="mt-4 space-y-1">
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('trade') }}">Trade &amp; export enquiries</a></li>
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('careers.index') }}">Careers</a></li>
                    <li><a class="inline-flex min-h-11 items-center hover:text-white" href="{{ route('careers.apply') }}">Send your CV</a></li>
                </ul>
            </div>
            <div>
                <h2 class="kicker font-sans text-white/60">The distillery</h2>
                <address class="mt-5 not-italic leading-relaxed">
                    {{ gdl('name') }}<br>{{ $address['street'] }}<br>{{ $address['parish'] }}, {{ $address['country'] }}
                </address>
                <a class="mt-1 inline-flex min-h-11 items-center gap-1.5 hover:text-white" href="{{ gdl('map_url') }}" rel="noopener" target="_blank">Get directions<x-icon name="external" class="h-3.5 w-3.5" /><span class="sr-only">(opens Google Maps)</span></a>
                <dl class="mt-4 space-y-1 text-sm">
                    @foreach (\App\Support\Hours::rows() as $days => $time)
                        <div class="flex justify-between gap-4"><dt>{{ $days }}</dt><dd class="num whitespace-nowrap text-white">{{ $time }}</dd></div>
                    @endforeach
                </dl>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="wrap py-6 text-sm text-white/65">
                <p class="flex items-start gap-2 text-white/80"><x-icon name="glass" class="mt-0.5 h-4 w-4 flex-none text-accent" />Enjoy Clarke's Court responsibly. Our rums are for adults of legal drinking age ({{ gdl('legal_age') }}+ in Grenada). Never drink and drive.</p>
                <div class="mt-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <p>© {{ date('Y') }} {{ gdl('name') }}. Clarke's Court is a brand of {{ gdl('name') }}.</p>
                    <p class="flex flex-wrap gap-x-5">
                        <a class="inline-flex min-h-11 min-w-11 items-center hover:text-white" href="{{ route('privacy') }}">Privacy</a>
                        <a class="inline-flex min-h-11 min-w-11 items-center hover:text-white" href="{{ route('credits') }}">Photo credits</a>
                        <a class="inline-flex min-h-11 min-w-11 items-center hover:text-white" href="{{ route('sitemap.page') }}">Site map</a>
                        <a class="inline-flex min-h-11 min-w-11 items-center hover:text-white" href="{{ route('login') }}">Staff sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    @if ($mobileBar)
        {{-- Thumb-reach actions on phones: email (or call when a number is set) and book a tour --}}
        <nav aria-label="Quick actions" class="fixed inset-x-0 bottom-0 z-30 border-t border-white/10 bg-molasses-900/95 px-3 pb-[max(0.75rem,env(safe-area-inset-bottom))] pt-3 backdrop-blur lg:hidden">
            <div class="flex gap-2">
                @if ($phone)
                    <a href="{{ tel_href($phone) }}" class="btn btn-on-dark flex-1 px-2 text-[0.9375rem]"><x-icon name="phone" class="h-4 w-4" />Call</a>
                @endif
                <a href="{{ route('contact') }}" class="btn btn-on-dark flex-1 px-2 text-[0.9375rem]"><x-icon name="mail" class="h-4 w-4" />Contact</a>
                <a href="{{ route('tours') }}#book" class="btn btn-accent flex-[1.4] whitespace-nowrap px-2 text-[0.9375rem]">Book a tour</a>
            </div>
        </nav>
    @endif
    @endif
</body>
</html>
