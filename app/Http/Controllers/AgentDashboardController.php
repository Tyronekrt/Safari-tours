<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;

class AgentDashboardController extends Controller
{
    /**
     * Display the agent dashboard.
     */
    public function index()
    {
        $agent = auth()->user();
        
        // Get assigned enquiries
        $assignedEnquiries = $agent->assignedEnquiries()->latest()->paginate(20);
        
        // Statistics
        $totalAssigned = $agent->assignedEnquiries()->count();
        $newEnquiries = $agent->assignedEnquiries()->where('status', 'new')->count();
        $contacted = $agent->assignedEnquiries()->where('status', 'contacted')->count();
        $confirmed = $agent->assignedEnquiries()->where('status', 'confirmed')->count();
        
        return view('agent.dashboard', compact(
            'agent',
            'assignedEnquiries',
            'totalAssigned',
            'newEnquiries',
            'contacted',
            'confirmed'
        ));
    }
}
