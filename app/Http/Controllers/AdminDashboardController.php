<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\User;
use App\Models\SafariPackage;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalEnquiries = Enquiry::count();
        $newEnquiries = Enquiry::where('status', 'new')->count();
        $confirmedBookings = Enquiry::where('status', 'confirmed')->count();
        $totalPackages = SafariPackage::count();
        $publishedPackages = SafariPackage::where('is_published', true)->count();

        // Calculate conversion rate
        $conversionRate = $totalEnquiries > 0 
            ? ($confirmedBookings / $totalEnquiries) * 100 
            : 0;

        // Enquiries by status
        $enquiriesByStatus = [
            'new' => Enquiry::where('status', 'new')->count(),
            'contacted' => Enquiry::where('status', 'contacted')->count(),
            'quotation_sent' => Enquiry::where('status', 'quotation_sent')->count(),
            'negotiation' => Enquiry::where('status', 'negotiation')->count(),
            'confirmed' => Enquiry::where('status', 'confirmed')->count(),
            'cancelled' => Enquiry::where('status', 'cancelled')->count(),
        ];

        // Recent activities
        $recentEnquiries = Enquiry::with(['package', 'assignedTo'])
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalEnquiries',
            'newEnquiries',
            'confirmedBookings',
            'totalPackages',
            'publishedPackages',
            'conversionRate',
            'enquiriesByStatus',
            'recentEnquiries',
            'recentUsers'
        ));
    }
}
