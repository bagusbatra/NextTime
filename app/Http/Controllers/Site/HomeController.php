<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\PricingPackage;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\WhyUsItem;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Jumlah maksimum kartu proyek yang tampil di teaser Portofolio beranda —
     * sisanya diarahkan ke halaman /projects lewat tombol "Lihat Semua".
     */
    private const FEATURED_PROJECTS_LIMIT = 6;

    public function __invoke(): View
    {
        $heroSlides = HeroSlide::query()
            ->active()
            ->ordered()
            ->get();

        $services = Service::query()
            ->active()
            ->ordered()
            ->get();

        $pricingPackages = PricingPackage::query()
            ->active()
            ->ordered()
            ->get();

        $whyUsItems = WhyUsItem::query()
            ->active()
            ->ordered()
            ->get();

        $whyUsCta = [
            'image' => Setting::get('why_us.cta_image'),
            'text' => Setting::get('why_us.cta_text', 'Konsultasi Gratis →'),
            'link' => Setting::get('why_us.cta_link', '#kontak'),
        ];

        $featuredProjects = Project::query()
            ->featured()
            ->ordered()
            ->take(self::FEATURED_PROJECTS_LIMIT)
            ->get();

        $clients = Client::query()
            ->active()
            ->ordered()
            ->get();

        $galleryItems = GalleryItem::query()
            ->active()
            ->ordered()
            ->get();

        $contactInfo = [
            'address' => Setting::get('contact.address', 'Surabaya, Jawa Timur, Indonesia'),
            'phone' => Setting::get('contact.phone', '+62 882-2827-2679'),
            'email' => Setting::get('contact.email', 'bagusbatr@gmail.com'),
            'work_hours' => Setting::get('contact.work_hours', 'Senin – Jumat: 08.00 – 17.00 WIB'),
        ];

        $sections = Setting::group('sections');

        return view('home', compact(
            'heroSlides',
            'services',
            'pricingPackages',
            'whyUsItems',
            'whyUsCta',
            'featuredProjects',
            'clients',
            'galleryItems',
            'contactInfo',
            'sections',
        ));
    }
}
