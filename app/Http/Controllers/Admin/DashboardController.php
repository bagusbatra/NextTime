<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\PricingPackage;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use App\Models\WhyUsItem;
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
            'users' => User::count(),
        ];

        /**
         * Ringkasan jumlah konten tiap section index — beserta link ke menu admin
         * terkait supaya dashboard jadi pintu masuk cepat ke seluruh modul.
         */
        $content = [
            ['label' => 'Hero / Slider', 'count' => HeroSlide::count(), 'route' => 'admin.hero-slides.index', 'icon' => 'gallery-horizontal'],
            ['label' => 'Layanan', 'count' => Service::count(), 'route' => 'admin.services.index', 'icon' => 'sparkles'],
            ['label' => 'Paket Harga', 'count' => PricingPackage::count(), 'route' => 'admin.pricing-packages.index', 'icon' => 'tags'],
            ['label' => 'Kenapa Kami', 'count' => WhyUsItem::count(), 'route' => 'admin.why-us-items.index', 'icon' => 'heart-handshake'],
            ['label' => 'Klien & Partner', 'count' => Client::count(), 'route' => 'admin.clients.index', 'icon' => 'building-2'],
            ['label' => 'Galeri', 'count' => GalleryItem::count(), 'route' => 'admin.gallery-items.index', 'icon' => 'image'],
        ];

        $newMessagesCount = ContactMessage::where('status', 'new')->count();

        $recentProjects = Project::query()->ordered()->latest()->take(5)->get();
        $recentUsers = User::query()->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'content', 'newMessagesCount', 'recentProjects', 'recentUsers'));
    }
}
