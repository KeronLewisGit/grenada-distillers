@props(['tone' => 'auto', 'small' => false])
{{--
    Typographic wordmark set in the display face, in the manner of a rum label: the brand name
    over a ruled line with the company and the founding year. A stand-in until Grenada
    Distillers supplies its logo artwork (see README, "Before launch").
--}}
<span {{ $attributes->merge(['class' => 'inline-flex flex-col leading-none '.($tone === 'light' ? 'text-white' : 'text-ink')]) }}>
    <span class="font-display whitespace-nowrap {{ $small ? 'text-[1.3rem]' : 'text-[1.45rem] min-[400px]:text-[1.7rem]' }} tracking-[0.005em]">Clarke's Court</span>
    <span class="mt-1 flex items-center gap-1.5 whitespace-nowrap border-t pt-1 text-[0.625rem] font-bold uppercase tracking-[0.2em] {{ $tone === 'light' ? 'border-accent/70 text-white/75' : 'border-cask text-ink-3' }}">Grenada Distillers<span aria-hidden="true">·</span>1937</span>
</span>
