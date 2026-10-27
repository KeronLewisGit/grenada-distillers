<x-layouts.admin title="Vacancies">
    <x-slot:actions>
        <a href="{{ route('admin.vacancies.create') }}" class="a-btn a-btn-primary"><x-icon name="plus" class="h-4 w-4" />New vacancy</a>
    </x-slot:actions>
    <section class="a-card overflow-hidden">
        @if ($jobs->isEmpty())
            <div class="px-5 py-14 text-center">
                <x-icon name="briefcase" class="mx-auto h-10 w-10 text-ink-3" />
                <p class="mt-3 font-semibold">No vacancies yet</p>
                <p class="mt-1 text-sm text-ink-3">Post one and it appears on /careers with an application form and CV upload.</p>
                <a href="{{ route('admin.vacancies.create') }}" class="a-btn a-btn-primary mt-5">New vacancy</a>
            </div>
        @else
            <div class="table-box">
                <table class="data-table min-w-[44rem]">
                    <thead><tr><th>Vacancy</th><th>Department</th><th>Closes</th><th class="r">Applicants</th><th class="r">New</th><th>Status</th><th><span class="sr-only">Actions</span></th></tr></thead>
                    <tbody>
                        @foreach ($jobs as $job)
                            <tr>
                                <td><a href="{{ route('admin.vacancies.edit', $job) }}" class="font-semibold hover:text-link">{{ $job->title }}</a>@if($job->is_demo)<span class="demo-badge ml-2 align-middle">Sample</span>@endif<span class="block text-xs text-ink-3">{{ $job->employment_type->label() }} · {{ $job->location }}</span></td>
                                <td class="whitespace-nowrap text-ink-2">{{ $job->department }}</td>
                                <td class="num whitespace-nowrap">{{ $job->closes_on?->format('j M Y') ?? 'Open until filled' }}</td>
                                <td class="r"><a class="inline-flex min-h-11 items-center hover:text-link" href="{{ route('admin.leads.index', ['type' => 'application']) }}">{{ number_format($job->applications_count) }}</a></td>
                                <td class="r">{{ number_format($job->new_count) }}</td>
                                <td><x-chip :tone="$job->status->tone()" :icon="$job->status->icon()">{{ $job->status->label() }}</x-chip></td>
                                <td class="r whitespace-nowrap">
                                    @if ($job->isOpen())<a href="{{ route('careers.show', $job) }}" target="_blank" rel="noopener" class="inline-flex min-h-11 items-center text-sm font-semibold text-link">View</a> · @endif
                                    <a href="{{ route('admin.vacancies.edit', $job) }}" class="inline-flex min-h-11 items-center text-sm font-semibold text-link">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</x-layouts.admin>
