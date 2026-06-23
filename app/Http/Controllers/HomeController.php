<?php

namespace App\Http\Controllers;

use App\Models\SafariPackage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $featuredPackages = SafariPackage::published()
            ->featured()
            ->limit(6)
            ->get();

        return view('home', compact('featuredPackages'));
    }

    /**
     * Show the about page.
     */
    public function about()
    {
        return view('about');
    }
}
