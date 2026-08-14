<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()->ordered()->get();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project): View
    {
        // Proyek berstatus "soon" belum punya halaman detail publik.
        if ($project->status !== 'available') {
            throw new NotFoundHttpException;
        }

        return view('projects.show', compact('project'));
    }
}
