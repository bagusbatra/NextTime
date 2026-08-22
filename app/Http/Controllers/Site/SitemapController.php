<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect([
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('projects.index'), 'priority' => '0.8'],
        ])->concat(
            Project::query()
                ->available()
                ->get()
                ->map(fn (Project $project) => [
                    'loc' => route('projects.show', $project->slug),
                    'priority' => '0.6',
                    'lastmod' => $project->updated_at->toAtomString(),
                ])
        );

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}
