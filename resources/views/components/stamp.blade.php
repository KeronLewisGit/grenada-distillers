@props(['no' => null, 'dark' => false])
{{-- Cask stamp: a numbered roundel and a letter-spaced word, like the mark on a barrel head. --}}
<p {{ $attributes->class(['stamp', 'on-dark' => $dark]) }}>@if($no !== null)<span class="no"><span>{{ $no }}</span></span>@endif<span>{{ $slot }}</span></p>
