<x-layouts.site title="Apply for a job" description="Apply for a job at Grenada Distillers, Woodlands, St George. Attach your CV and get a reference number straight away.">
    <x-page-header photo="{{ gdl('careers.photo') }}" no="C" label="Careers" title="Apply for a job"
        :lead="$selected ? 'You are applying for '.$selected->title.'. Fill this in and attach your CV; it takes about five minutes.' : 'Choose a vacancy, or send a general application. Fill this in and attach your CV; it takes about five minutes.'" />

    <section class="wrap mt-12 md:mt-16">
        <form method="POST" action="{{ route('careers.store') }}" enctype="multipart/form-data" class="grid gap-12 lg:grid-cols-[1.5fr_1fr] lg:gap-16" x-data="leadForm" @submit="submit">
            @csrf
            <div class="space-y-12">
                <x-form-errors />
                <fieldset class="space-y-5">
                    <legend class="fieldset-title mb-5"><span class="step">1</span>The role</legend>
                    <x-select name="job" label="Vacancy" :required="true" :value="$selected?->id" placeholder="Choose a vacancy…">
                        @foreach ($jobs as $j)<option value="{{ $j->id }}" @selected(old_string('job', $selected?->id) === (string) $j->id)>{{ $j->title }} ({{ $j->department }})</option>@endforeach
                        <option value="general" @selected(old('job') === 'general')>General application (no specific vacancy)</option>
                    </x-select>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-field name="current_role" label="Current or last job" :optional="true" maxlength="160" />
                        <x-field name="available_from" label="Earliest start date" type="date" :optional="true" :min="today()->toDateString()" />
                    </div>
                </fieldset>
                <x-contact-fields :step="2" email-hint="We email your reference number here." />
                <fieldset class="space-y-5">
                    <legend class="fieldset-title mb-5"><span class="step">3</span>About you</legend>
                    <x-select name="parish" label="Where you live" :options="gdl('parishes')" :required="true" />
                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-select name="experience" label="Experience in similar work" :options="gdl('careers.experience')" :required="true" />
                        <x-select name="qualification" label="Highest qualification" :options="gdl('careers.qualifications')" :required="true" />
                    </div>
                    <x-field name="cv" label="Your CV" type="file" :required="! $pendingCv" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" :hint="$pendingCv ? 'Attached: '.$pendingCv['name'].' ('.max(1, (int) round($pendingCv['size'] / 1024)).' KB). Choose a file only to replace it.' : 'PDF or Word, up to 5 MB.'" />
                    <x-field name="message" label="A short note to HR" type="textarea" :optional="true" maxlength="3000" rows="4" />
                    <label class="choice items-start"><input type="checkbox" name="consent" value="1" required @checked(old('consent')) class="mt-0.5"><span>I agree that Grenada Distillers may keep my application and CV for 12 months to consider me for this and similar roles.</span></label>
                    <x-error for="consent" />
                </fieldset>
                <div>
                    <x-submit label="Send my application" />
                </div>
            </div>
            <aside class="space-y-5">
                <div class="label-frame p-6 md:p-8">
                    <h2 class="font-sans text-lg font-bold">Your CV stays private</h2>
                    <p class="mt-2 text-[0.9375rem] text-ink-2">It is stored outside the public website, and only Human Resources can open it. Each time it is opened, that is recorded. See our <a class="text-link" href="{{ route('privacy') }}">privacy notice</a>.</p>
                </div>
                @if ($jobs->isNotEmpty())
                    <div class="panel p-6">
                        <h2 class="font-sans text-lg font-bold">Open vacancies</h2>
                        <ul class="mt-2">@foreach ($jobs as $j)<li><a class="text-link inline-flex min-h-11 items-center" href="{{ route('careers.show', $j) }}">{{ $j->title }}</a></li>@endforeach</ul>
                    </div>
                @endif
            </aside>
        </form>
    </section>
</x-layouts.site>
