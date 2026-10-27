@props(['code'])
@php
    $copy = [
        '404' => ['That page has moved', 'The link may be from our old website. The rums, tours, trade enquiries and careers are all still here.'],
        '403' => ['You can\'t open that', 'Your account doesn\'t have access to this page. Ask an administrator if you need it.'],
        '419' => ['Your session timed out', 'For your security the form expired. Go back, refresh the page and send it again.'],
        '429' => ['Too many tries', 'Please wait a minute and try again, or email us.'],
        '500' => ['Something went wrong on our side', 'Please try again in a minute. If you were sending a form, email us and we will take it from there.'],
        '503' => ['Back shortly', 'We are updating the website. Please try again in a few minutes.'],
    ][$code] ?? ['Something went wrong', 'Please try again.'];
@endphp
<x-layouts.site :title="$copy[0]">
    <x-page-header :title="$copy[0]" :lead="$copy[1]" :no="$code" label="Error" photo="casks" />
    <section class="wrap mt-12 flex flex-wrap gap-3 md:mt-16">
        <a href="{{ route('home') }}" class="btn btn-accent">Go to the home page<x-icon name="arrow-right" class="nudge h-4 w-4" /></a>
        @if ($code === '404')
            <a href="{{ route('rums.index') }}" class="btn btn-outline">See the rums</a>
        @endif
        <a href="mailto:{{ gdl('email') }}" class="btn btn-outline"><x-icon name="mail" class="h-4 w-4" />{{ gdl('email') }}</a>
    </section>
</x-layouts.site>
