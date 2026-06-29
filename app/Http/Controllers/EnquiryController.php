<?php

namespace App\Http\Controllers;

use App\Mail\EnquiryStatusUpdate;
use App\Models\Enquiry;
use App\Models\EnquiryNote;
use App\Models\EnquiryStatusHistory;
use App\Models\FollowUpReminder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
    /**
     * Show the enquiry form (public).
     */
    public function create()
    {
        $packages = \App\Models\SafariPackage::published()->get();
        return view('enquiry', compact('packages'));
    }

    /**
     * Store a newly created enquiry in storage (public).
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'package_id' => 'nullable|exists:safari_packages,id',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'travel_date' => 'nullable|date',
            'duration' => 'nullable|integer',
            'budget' => 'nullable|string|max:50',
            'message' => 'nullable|string|max:5000',
        ]);

        $enquiry = Enquiry::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'package_id' => $request->package_id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'adults' => $request->adults,
            'children' => $request->children,
            'travel_date' => $request->travel_date,
            'duration' => $request->duration,
            'budget' => $request->budget,
            'message' => $request->message,
            'status' => 'new',
        ]);

        // Create initial status history
        EnquiryStatusHistory::create([
            'enquiry_id' => $enquiry->id,
            'status' => 'new',
            'changed_by' => auth()->check() ? auth()->id() : null,
            'changed_at' => now(),
        ]);

        // Increment package enquiries count if package selected
        if ($request->package_id) {
            $package = \App\Models\SafariPackage::find($request->package_id);
            if ($package) {
                $package->increment('enquiries_count');
            }
        }

        return redirect()->route('enquiry.thank-you')
            ->with('success', 'Your enquiry has been submitted successfully. We will contact you shortly.');
    }

    /**
     * Show thank you page.
     */
    public function thankYou()
    {
        return view('enquiry-thank-you');
    }

    /**
     * Display a listing of enquiries (admin).
     */
    public function adminIndex(Request $request)
    {
        $query = Enquiry::with(['user', 'assignedTo', 'package']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by assigned user
        if ($request->has('assigned_to') && $request->assigned_to) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $enquiries = $query->latest()->paginate(20);
        $salesAgents = User::role('sales_agent')->get();
        $statuses = ['new', 'contacted', 'quotation_sent', 'negotiation', 'confirmed', 'cancelled'];

        return view('admin.enquiries.index', compact('enquiries', 'salesAgents', 'statuses'));
    }

    /**
     * Display the specified enquiry (admin).
     */
    public function show(Enquiry $enquiry)
    {
        $enquiry->load(['user', 'assignedTo', 'package', 'notes.user', 'statusHistory.changedByUser', 'reminders']);
        $salesAgents = User::role('sales_agent')->get();
        $statuses = ['new', 'contacted', 'quotation_sent', 'negotiation', 'confirmed', 'cancelled'];

        return view('admin.enquiries.show', compact('enquiry', 'salesAgents', 'statuses'));
    }

    /**
     * Assign enquiry to sales agent (admin).
     */
    public function assign(Request $request, Enquiry $enquiry)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $enquiry->update([
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->back()
            ->with('success', 'Enquiry assigned successfully.');
    }

    /**
     * Update enquiry status (admin/sales).
     */
    public function updateStatus(Request $request, Enquiry $enquiry)
    {
        $request->validate([
            'status' => 'required|in:new,contacted,quotation_sent,negotiation,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $enquiry->update([
            'status' => $request->status,
            'last_contacted_at' => now(),
        ]);

        // Create status history
        EnquiryStatusHistory::create([
            'enquiry_id' => $enquiry->id,
            'status' => $request->status,
            'changed_by' => auth()->id(),
            'notes' => $request->notes,
            'changed_at' => now(),
        ]);

        // Send email notification for important status changes
        if (in_array($request->status, ['confirmed', 'cancelled', 'quotation_sent'])) {
            try {
                Mail::to($enquiry->email)->send(new EnquiryStatusUpdate($enquiry, $request->status, $request->notes));
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Log::error('Email sending failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()
            ->with('success', 'Enquiry status updated successfully.');
    }

    /**
     * Approve enquiry (admin).
     */
    public function approve(Enquiry $enquiry)
    {
        $enquiry->update([
            'status' => 'confirmed',
            'last_contacted_at' => now(),
        ]);

        // Create status history
        EnquiryStatusHistory::create([
            'enquiry_id' => $enquiry->id,
            'status' => 'confirmed',
            'changed_by' => auth()->id(),
            'notes' => 'Enquiry approved and confirmed',
            'changed_at' => now(),
        ]);

        // Send email notification
        try {
            Mail::to($enquiry->email)->send(new EnquiryStatusUpdate($enquiry, 'confirmed', 'Enquiry approved and confirmed'));
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Enquiry approved successfully.');
    }

    /**
     * Reject enquiry (admin).
     */
    public function reject(Request $request, Enquiry $enquiry)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $enquiry->update([
            'status' => 'cancelled',
            'last_contacted_at' => now(),
        ]);

        $notes = 'Rejected: ' . $request->rejection_reason;

        // Create status history
        EnquiryStatusHistory::create([
            'enquiry_id' => $enquiry->id,
            'status' => 'cancelled',
            'changed_by' => auth()->id(),
            'notes' => $notes,
            'changed_at' => now(),
        ]);

        // Send email notification
        try {
            Mail::to($enquiry->email)->send(new EnquiryStatusUpdate($enquiry, 'cancelled', $notes));
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Enquiry rejected successfully.');
    }

    /**
     * Add note to enquiry (admin/sales).
     */
    public function addNote(Request $request, Enquiry $enquiry)
    {
        $request->validate([
            'note' => 'required|string',
            'is_internal' => 'boolean',
        ]);

        EnquiryNote::create([
            'enquiry_id' => $enquiry->id,
            'user_id' => auth()->id(),
            'note' => $request->note,
            'is_internal' => $request->boolean('is_internal'),
        ]);

        return redirect()->back()
            ->with('success', 'Note added successfully.');
    }

    /**
     * Set follow-up reminder (admin/sales).
     */
    public function setReminder(Request $request, Enquiry $enquiry)
    {
        $request->validate([
            'reminder_date' => 'required|date',
            'reminder_time' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        FollowUpReminder::create([
            'enquiry_id' => $enquiry->id,
            'reminder_date' => $request->reminder_date,
            'reminder_time' => $request->reminder_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->back()
            ->with('success', 'Reminder set successfully.');
    }

    /**
     * Delete enquiry (admin).
     */
    public function destroy(Enquiry $enquiry)
    {
        \Log::info('Attempting to delete enquiry', ['enquiry_id' => $enquiry->id, 'email' => $enquiry->email]);

        try {
            $enquiry->delete();

            \Log::info('Enquiry deleted successfully', ['enquiry_id' => $enquiry->id]);

            return redirect()->route('admin.enquiries.index')
                ->with('success', 'Enquiry deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to delete enquiry', ['enquiry_id' => $enquiry->id, 'error' => $e->getMessage()]);

            return redirect()->route('admin.enquiries.index')
                ->with('error', 'Failed to delete enquiry: ' . $e->getMessage());
        }
    }
}
