@props(['abv', 'small' => false])
{{-- Proof seal: the ABV in a round medallion. --}}
<span {{ $attributes->class(['seal', 'sm' => $small]) }} role="img" aria-label="{{ $abv }}% alcohol by volume"><span aria-hidden="true"><b>{{ $abv }}<span class="text-[0.6em] align-top">%</span></b><small>ABV</small></span></span>
