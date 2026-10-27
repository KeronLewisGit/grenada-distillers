@props(['title', 'lead' => null, 'no' => null, 'label' => "Clarke's Court", 'photo' => null, 'position' => 'center', 'alt' => ''])
{{--
    The one hero band every inner page uses, so titles start at the same height and left edge
    site-wide. Molasses band; with a photo it sits behind a scrim. The title sits under a cask
    stamp, and barrel hoops run along the foot. Extra content (breadcrumbs, actions) goes in the slot.
--}}
<section data-page-header {{ $attributes->merge(['class' => 'relative isolate overflow-hidden bg-molasses-900 text-white on-dark']) }}>
    @if ($photo)
        <div class="hero-photo absolute inset-0 -z-10">
            <x-photo :key="$photo" :alt="$alt" :eager="true" sizes="100vw" class="h-full w-full" :position="$position" />
            <div class="hero-scrim absolute inset-0"></div>
        </div>
    @endif
    <div class="wrap pb-11 pt-10 md:pb-16 md:pt-20">
        <x-stamp :no="$no" :dark="true">{{ $label }}</x-stamp>
        <h1 class="display-2 mt-5 max-w-4xl">{{ $title }}</h1>
        @if ($lead)<p class="lead mt-4 text-white/85 md:mt-5">{{ $lead }}</p>@endif
        {{ $slot }}
    </div>
    <div class="hoops" aria-hidden="true"></div>
</section>
