<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function create()
    {
        return view('contact');
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new',
            ]);

            return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
        } catch (\Exception $e) {
            return redirect()->route('contact')
                ->with('error', 'Error sending message: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display a listing of contacts (admin).
     */
    public function adminIndex()
    {
        $contacts = Contact::with('replier')
            ->latest()
            ->paginate(20);

        $statuses = ['new', 'read', 'replied', 'closed'];

        return view('admin.contacts.index', compact('contacts', 'statuses'));
    }

    /**
     * Display the specified contact (admin).
     */
    public function show(Contact $contact)
    {
        // Mark as read if not already read
        if (!$contact->read_at) {
            $contact->update([
                'read_at' => now(),
                'status' => 'read'
            ]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update the specified contact status (admin).
     */
    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,closed',
            'admin_notes' => 'nullable|string',
        ]);

        $contact->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'replied_at' => $request->status === 'replied' ? now() : $contact->replied_at,
            'replied_by' => $request->status === 'replied' ? auth()->id() : $contact->replied_by,
        ]);

        return redirect()->back()->with('success', 'Contact status updated successfully.');
    }

    /**
     * Remove the specified contact from storage (admin).
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }

    /**
     * Mark contact as replied (admin).
     */
    public function markAsReplied(Contact $contact)
    {
        $contact->update([
            'status' => 'replied',
            'replied_at' => now(),
            'replied_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Contact marked as replied.');
    }

    /**
     * Mark contact as closed (admin).
     */
    public function markAsClosed(Contact $contact)
    {
        $contact->update([
            'status' => 'closed',
        ]);

        return redirect()->back()->with('success', 'Contact marked as closed.');
    }
}
