<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Models\JobPosting;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(): View
    {
        return view('pages.careers.index', [
            // Closing soonest first; open-ended postings last.
            'jobs' => JobPosting::open()->orderByRaw('closes_on is null')->orderBy('closes_on')->latest()->get(),
        ]);
    }

    public function show(JobPosting $job): View
    {
        abort_if($job->status === JobStatus::Draft, 404);

        return view('pages.careers.show', ['job' => $job]);
    }
}
