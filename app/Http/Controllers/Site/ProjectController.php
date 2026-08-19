<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectController extends Controller
{
    /** Kategori valid untuk filter publik — dipakai juga untuk validasi query string. */
    public const CATEGORIES = [
        'umkm' => 'UMKM',
        'company-profile' => 'Company Profile',
        'landing-page' => 'Landing Page',
    ];

    private const PER_PAGE = 9;

    private const RELATED_LIMIT = 3;

    public function index(Request $request): View
    {
        $category = $request->string('category')->value();
        $category = array_key_exists($category, self::CATEGORIES) ? $category : null;

        $projects = Project::query()
            ->when($category, fn ($query) => $query->where('category', $category))
            ->ordered()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('projects.index', [
            'projects' => $projects,
            'categories' => self::CATEGORIES,
            'activeCategory' => $category,
        ]);
    }

    public function show(Project $project): View
    {
        // Proyek berstatus "soon" belum punya halaman detail publik.
        if ($project->status !== 'available') {
            throw new NotFoundHttpException;
        }

        // Proyek terkait: prioritaskan kategori yang sama, lalu lengkapi dari kategori lain bila kurang.
        $relatedProjects = Project::query()
            ->where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->ordered()
            ->take(self::RELATED_LIMIT)
            ->get();

        if ($relatedProjects->count() < self::RELATED_LIMIT) {
            $extra = Project::query()
                ->where('id', '!=', $project->id)
                ->where('category', '!=', $project->category)
                ->whereNotIn('id', $relatedProjects->pluck('id'))
                ->ordered()
                ->take(self::RELATED_LIMIT - $relatedProjects->count())
                ->get();

            $relatedProjects = $relatedProjects->concat($extra);
        }

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
