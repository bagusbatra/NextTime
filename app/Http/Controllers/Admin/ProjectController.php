<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::query()->ordered()->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.create', ['project' => new Project]);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        Project::create($this->prepare($request->validated()));

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Proyek berhasil ditambahkan.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $project->update($this->prepare($request->validated()));

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('status', 'Proyek berhasil dihapus.');
    }

    /**
     * Ubah textarea "satu fitur per baris" menjadi array, dan set default checkbox.
     */
    private function prepare(array $data): array
    {
        $data['features'] = collect(explode("\n", $data['features'] ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $data['featured'] = $data['featured'] ?? false;

        return $data;
    }
}
