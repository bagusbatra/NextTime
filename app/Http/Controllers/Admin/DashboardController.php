<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $stats = [
            'total' => Project::count(),
            'available' => Project::where('status', 'available')->count(),
            'soon' => Project::where('status', 'soon')->count(),
            'featured' => Project::where('featured', true)->count(),
        ];

        $recentProjects = Project::query()->ordered()->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProjects'));
    }
}
