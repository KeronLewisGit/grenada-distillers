{{-- A bottle on the shelf: the bottle on a paper-coloured tile (same in both themes), name, style and ABV. --}}
@php($cover = ! empty($rum['cover']))
<li class="card-link group flex flex-col">
    <div class="card-img bottle-tile relative aspect-[3/4] overflow-hidden rounded-md {{ $cover ? '' : 'px-4 pt-6' }}">
        <x-photo :key="$rum['photo']" :alt="$cover ? 'Nutmeg drying in Grenada, the spice in '.$rum['name'] : $rum['name'].' bottle'" sizes="(min-width: 1024px) 20vw, (min-width: 640px) 30vw, 45vw" :class="$cover ? 'h-full w-full' : 'photo-contain h-full w-full !bg-transparent'" />
        @if (! empty($rum['abv']))<x-seal :abv="$rum['abv']" :small="true" class="absolute right-2 top-2" />@endif
    </div>
    <p class="kicker mt-4 text-ink-3">{{ $rum['style'] }}</p>
    <h3 class="font-display mt-1 text-2xl leading-tight"><a class="stretch" href="{{ route('rums.show', $key) }}">{{ $rum['name'] }}</a></h3>
</li>
