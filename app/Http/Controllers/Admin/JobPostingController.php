<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EmploymentType;
use App\Enums\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\JobPosting;
use App\Support\Slug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/** Vacancies on /careers, managed by HR. */
class JobPostingController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', JobPosting::class);

        return view('admin.vacancies.index', [
            'jobs' => JobPosting::withCount([
                'applications',
                'applications as new_count' => fn ($q) => $q->where('status', 'new'),
            ])->orderByRaw("case status when 'open' then 0 when 'draft' then 1 else 2 end")->latest()->get(),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', JobPosting::class);

        return view('admin.vacancies.form', ['job' => new JobPosting(['status' => JobStatus::Draft, 'location' => 'Woodlands, St George', 'employment_type' => EmploymentType::FullTime])]);
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', JobPosting::class);
        $data = $this->validated($request);
        $data['slug'] = Slug::unique(JobPosting::class, $data['title'], 'vacancy');
        $job = JobPosting::create($data);

        return to_route('admin.vacancies.edit', $job)->with('status', 'Vacancy created.');
    }

    public function edit(JobPosting $job): View
    {
        Gate::authorize('update', $job);

        return view('admin.vacancies.form', ['job' => $job]);
    }

    public function update(Request $request, JobPosting $job): RedirectResponse
    {
        Gate::authorize('update', $job);
        $job->update($this->validated($request));

        return back()->with('status', 'Vacancy saved.');
    }

    public function destroy(JobPosting $job): RedirectResponse
    {
        Gate::authorize('delete', $job);
        if ($job->applications()->exists()) {
            $job->update(['status' => JobStatus::Closed]);

            return to_route('admin.vacancies.index')->with('status', 'That vacancy has applicants, so it was closed instead of deleted.');
        }
        $job->delete();

        return to_route('admin.vacancies.index')->with('status', 'Vacancy deleted.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $text = ['nullable', 'string', 'max:5000'];

        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'department' => ['required', 'string', 'max:60'],
            'employment_type' => ['required', Rule::enum(EmploymentType::class)],
            'status' => ['required', Rule::enum(JobStatus::class)],
            'location' => ['required', 'string', 'max:120'],
            'closes_on' => ['nullable', 'date'],
            'summary' => ['required', 'string', 'max:600'],
            'duties' => $text,
            'requirements' => $text,
        ]);
    }
}
