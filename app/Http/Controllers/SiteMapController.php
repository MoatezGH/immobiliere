<?php

namespace App\Http\Controllers;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post; // Adjust this to your model for dynamic URLs
use Illuminate\Support\Facades\DB;

class SitemapController extends Controller
{
    public function generateSitemap()
    {
        // Create a new sitemap instance
        $sitemap = Sitemap::create();

        // Add static URLs (Home, About, Contact, etc.)
        $sitemap->add(Url::create('/')->setPriority(1.0))
        ->add(Url::create('/properties/promoteur')->setPriority(0.9))
        ->add(Url::create('/properties')->setPriority(0.9))
        ->add(Url::create('/all/classified')->setPriority(0.9))
        ->add(Url::create('/all/services')->setPriority(0.9))
        ->add(Url::create('/login')->setPriority(0.9))
        ->add(Url::create('/account_type')->setPriority(0.8))
        ->add(Url::create('/register/annonceur_immobilier')->setPriority(0.8))
        ->add(Url::create('/service_user/register')->setPriority(0.8))
        ->add(Url::create('/classifed_user/register')->setPriority(0.8))
        ->add(Url::create('/stores')->setPriority(0.9))
        ->add(Url::create('/about_us')->setPriority(0.8))
        ->add(Url::create('/contact')->setPriority(0.7))
        ->add(Url::create('/term_condition')->setPriority(0.7));


        

        // Write sitemap to a file
        $sitemap->writeToFile(public_path('sitemap.xml'));

        return response()->json('Sitemap generated successfully.');
    }
}
