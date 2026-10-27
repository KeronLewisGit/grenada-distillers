@php($editing = $job->exists)
<x-layouts.admin :title="$editing ? 'Edit vacancy' : 'New vacancy'">
    <x-slot:actions>
        <a href="{{ route('admin.vacancies.index') }}" class="a-btn a-btn-ghost">All vacancies</a>
    </x-slot:actions>
    <form method="POST" action="{{ $editing ? route('admin.vacancies.update', $job) : route('admin.vacancies.store') }}" class="grid max-w-5xl gap-6 xl:grid-cols-[1.5fr_1fr]">
        @csrf @if($editing) @method('PUT') @endif
        <section class="a-card space-y-4 p-5">
            <div><label for="title" class="mb-1 block text-sm font-semibold">Job title</label><input id="title" name="title" value="{{ old('title', $job->title) }}" class="a-input w-full" required maxlength="120"></div>
            <div><label for="summary" class="mb-1 block text-sm font-semibold">Summary</label><textarea id="summary" name="summary" rows="3" class="a-input w-full" required maxlength="600">{{ old('summary', $job->summary) }}</textarea><p class="mt-1 text-xs text-ink-3">Two or three sentences, shown on the careers list.</p></div>
            <div><label for="duties" class="mb-1 block text-sm font-semibold">What you'll do</label><textarea id="duties" name="duties" rows="6" class="a-input w-full" maxlength="5000">{{ old('duties', $job->duties) }}</textarea><p class="mt-1 text-xs text-ink-3">One duty per line.</p></div>
            <div><label for="requirements" class="mb-1 block text-sm font-semibold">What you'll need</label><textarea id="requirements" name="requirements" rows="6" class="a-input w-full" maxlength="5000">{{ old('requirements', $job->requirements) }}</textarea><p class="mt-1 text-xs text-ink-3">One requirement per line.</p></div>
        </section>
        <div class="space-y-6">
            <section class="a-card space-y-4 p-5">
                <div><label for="status" class="mb-1 block text-sm font-semibold">Status</label>
                    <select id="status" name="status" class="a-input w-full">@foreach (\App\Enums\JobStatus::cases() as $s)<option value="{{ $s->value }}" @selected(old('status', $job->status?->value) === $s->value)>{{ $s->label() }}</option>@endforeach</select>
                    <p class="mt-1 text-xs text-ink-3">Only open vacancies show on the website.</p></div>
                <div><label for="department" class="mb-1 block text-sm font-semibold">Department</label><input id="department" name="department" value="{{ old('department', $job->department) }}" class="a-input w-full" required maxlength="60" list="departments">
                    <datalist id="departments">@foreach (['Production', 'Bottling', 'Warehouse & logistics', 'Finance & accounts', 'Sales & marketing', 'Tours & visitor centre', 'Administration'] as $dep)<option value="{{ $dep }}">@endforeach</datalist></div>
                <div><label for="employment_type" class="mb-1 block text-sm font-semibold">Type</label>
                    <select id="employment_type" name="employment_type" class="a-input w-full">@foreach (\App\Enums\EmploymentType::cases() as $t)<option value="{{ $t->value }}" @selected(old('employment_type', $job->employment_type?->value) === $t->value)>{{ $t->label() }}</option>@endforeach</select></div>
                <div><label for="location" class="mb-1 block text-sm font-semibold">Location</label><input id="location" name="location" value="{{ old('location', $job->location) }}" class="a-input w-full" required maxlength="120"></div>
                <div><label for="closes_on" class="mb-1 block text-sm font-semibold">Applications close</label><input id="closes_on" name="closes_on" type="date" value="{{ old('closes_on', $job->closes_on?->toDateString()) }}" class="a-input w-full"><p class="mt-1 text-xs text-ink-3">Blank = open until filled.</p></div>
                <button class="a-btn a-btn-primary w-full">{{ $editing ? 'Save vacancy' : 'Create vacancy' }}</button>
            </section>
        </div>
    </form>
    @if ($editing)
        <form method="POST" action="{{ route('admin.vacancies.destroy', $job) }}" class="mt-6" onsubmit="return confirm('Delete this vacancy? If anyone has applied it will be closed instead.')">
            @csrf @method('DELETE')
            <button class="a-btn a-btn-ghost text-[color:var(--critical-text)]"><x-icon name="trash" class="h-4 w-4" />Delete vacancy</button>
        </form>
    @endif
</x-layouts.admin>
