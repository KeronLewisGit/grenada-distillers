<x-layouts.site title="Are you of legal drinking age?" :chrome="false" description="Clarke's Court rum is for adults of legal drinking age. Please confirm your age to enter.">
    <x-page-header photo="hero" :position="gdl('photos.hero.position', 'center')" :no="gdl('legal_age').'+'" label="Age check"
        :title="$declined ? 'Thank you for your honesty.' : 'Welcome to Clarke\'s Court.'"
        :lead="$declined ? 'This website is about rum, so it is only for adults of legal drinking age. Please come back when you are '.gdl('legal_age').'.' : 'Our rums are for adults. Are you '.gdl('legal_age').' or older, the legal drinking age in Grenada?'">
        @unless ($declined)
            <form method="POST" action="{{ route('age.store') }}" class="mt-8 max-w-xl">
                @csrf
                <input type="hidden" name="next" value="{{ $next }}">
                <div class="flex flex-wrap gap-3">
                    <button type="submit" name="answer" value="yes" class="btn btn-accent min-w-40 text-lg">Yes, I am {{ gdl('legal_age') }} or older</button>
                    <button type="submit" name="answer" value="no" class="btn btn-on-dark min-w-32 text-lg">No</button>
                </div>
                <label class="mt-5 flex min-h-11 items-center gap-3 text-white/85"><input type="checkbox" name="remember" value="1" class="h-5 w-5 accent-[var(--accent)]">Remember me on this device for 30 days</label>
                <p class="on-dark mt-3 max-w-md text-sm text-white/70">If you are visiting from a country where the legal drinking age is higher, please follow your local law. By entering you accept our <a href="{{ route('privacy') }}" class="text-link">privacy notice</a>; we set one small cookie to remember your answer.</p>
            </form>
        @else
            <p class="mt-8"><a href="{{ route('age.show') }}" class="btn btn-on-dark">I answered by mistake</a></p>
        @endunless
        <div class="ribbon mt-10 max-w-40" aria-hidden="true"></div>
        <p class="mt-4 flex items-center gap-2 text-sm text-white/70"><x-icon name="glass" class="h-4 w-4 text-accent" />Enjoy responsibly. Never drink and drive.</p>
    </x-page-header>
    <div class="wrap flex flex-col items-start gap-3 py-8 text-sm text-ink-3 sm:flex-row sm:items-center sm:justify-between">
        <x-logo />
        <p>{{ gdl('name') }} · {{ gdl('address.locality') }}, {{ gdl('address.parish') }}, Grenada · <a href="{{ route('credits') }}" class="text-link">Photo credits</a></p>
    </div>
</x-layouts.site>
