<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $featuredProjects = Project::query()
            ->featured()
            ->ordered()
            ->get();

        return view('home', compact('featuredProjects'));
    }
}
