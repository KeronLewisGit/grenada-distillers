<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Support\Rums;
use App\Support\Tours;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $next = collect(Tours::grid())->first(fn (array $d) => array_sum($d['slots']) > 0);

        return view('pages.home', [
            'families' => Rums::byFamily(),
            'nextTour' => $next,
            'openJobs' => JobPosting::open()->count(),
        ]);
    }

    public function heritage(): View
    {
        return view('pages.heritage');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function credits(): View
    {
        return view('pages.credits');
    }

    public function sitemapPage(): View
    {
        return view('pages.sitemap', ['jobs' => JobPosting::open()->orderBy('title')->get(['slug', 'title'])]);
    }

    public function sitemap(): Response
    {
        $static = ['home', 'rums.index', 'heritage', 'tours', 'trade', 'careers.index', 'careers.apply', 'contact', 'privacy', 'credits', 'sitemap.page'];
        $urls = collect($static)->map(fn (string $name) => ['loc' => route($name), 'lastmod' => null])
            ->concat(collect(Rums::all())->keys()->map(fn (string $key) => ['loc' => route('rums.show', $key), 'lastmod' => null]))
            ->concat(JobPosting::open()->get()->map(fn (JobPosting $j) => ['loc' => route('careers.show', $j), 'lastmod' => $j->updated_at?->toAtomString()]));

        return response()->view('sitemap', ['urls' => $urls])->header('Content-Type', 'application/xml');
    }
}
