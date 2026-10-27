@php
    $next = match ($type) {
        \App\Enums\LeadType::Tour => 'Your places on the tour are held. We have emailed your booking, and the tours team will confirm it with you.',
        \App\Enums\LeadType::Trade => 'Our export team will read your enquiry and reply by email, usually within two working days.',
        \App\Enums\LeadType::Application => 'Our HR team reviews every application. If you are shortlisted, we will contact you to arrange an interview.',
        default => 'We will get back to you during office hours.',
    };
@endphp
<x-layouts.site title="Thank you" :mobile-bar="false">
    <x-page-header title="Thank you. We have it." :lead="$next" no="✓" :label="$type->label()" photo="casks" />
    <section class="wrap mt-12 md:mt-16">
        <div class="label-frame max-w-xl p-8 md:p-10">
            <p class="kicker text-ink-3">Your reference</p>
            <p class="font-display num mt-3 text-4xl tracking-wide sm:text-5xl">{{ $reference }}</p>
            <p class="mt-5 text-ink-2">We've emailed it to you too. Quote it if you write or call, and we'll find your request straight away.</p>
        </div>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('rums.index') }}" class="btn btn-outline">Explore the rums</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Back to the home page</a>
        </div>
    </section>
</x-layouts.site>
