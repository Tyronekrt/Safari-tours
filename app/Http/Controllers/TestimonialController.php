<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the testimonials (admin).
     */
    public function adminIndex()
    {
        $testimonials = Testimonial::latest()->paginate(20);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial (admin).
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created testimonial in storage (admin).
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'content' => 'required|string',
                'rating' => 'nullable|integer|min:1|max:5',
                'package_name' => 'nullable|string|max:255',
                'travel_date' => 'nullable|date',
                'is_approved' => 'nullable|boolean',
                'is_featured' => 'nullable|boolean',
                'display_order' => 'nullable|integer',
            ]);

            $customerImagePath = null;
            if ($request->hasFile('customer_image')) {
                $customerImagePath = $request->file('customer_image')->store('testimonials', 'public');
            }

            Testimonial::create([
                'customer_name' => $request->customer_name,
                'customer_image' => $customerImagePath,
                'content' => $request->content,
                'rating' => $request->rating ?? 5,
                'package_name' => $request->package_name,
                'travel_date' => $request->travel_date,
                'is_approved' => $request->boolean('is_approved', true),
                'is_featured' => $request->boolean('is_featured', false),
                'display_order' => $request->display_order ?? 0,
            ]);

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.testimonials.create')
                ->with('error', 'Error creating testimonial: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified testimonial (admin).
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage (admin).
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'package_name' => 'nullable|string|max:255',
            'travel_date' => 'nullable|date',
            'is_approved' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'display_order' => 'nullable|integer',
        ]);

        $customerImagePath = $testimonial->customer_image;
        if ($request->hasFile('customer_image')) {
            // Delete old image if exists
            if ($testimonial->customer_image) {
                \Storage::disk('public')->delete($testimonial->customer_image);
            }
            $customerImagePath = $request->file('customer_image')->store('testimonials', 'public');
        }

        $testimonial->update([
            'customer_name' => $request->customer_name,
            'customer_image' => $customerImagePath,
            'content' => $request->content,
            'rating' => $request->rating ?? 5,
            'package_name' => $request->package_name,
            'travel_date' => $request->travel_date,
            'is_approved' => $request->boolean('is_approved', true),
            'is_featured' => $request->boolean('is_featured', false),
            'display_order' => $request->display_order ?? 0,
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified testimonial from storage (admin).
     */
    public function destroy(Testimonial $testimonial)
    {
        \Log::info('Attempting to delete testimonial', ['testimonial_id' => $testimonial->id, 'customer_name' => $testimonial->customer_name]);

        try {
            // Delete image if exists
            if ($testimonial->customer_image) {
                \Storage::disk('public')->delete($testimonial->customer_image);
            }

            $testimonial->delete();

            \Log::info('Testimonial deleted successfully', ['testimonial_id' => $testimonial->id]);

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to delete testimonial', ['testimonial_id' => $testimonial->id, 'error' => $e->getMessage()]);

            return redirect()->route('admin.testimonials.index')
                ->with('error', 'Failed to delete testimonial: ' . $e->getMessage());
        }
    }

    /**
     * Toggle approved status (admin).
     */
    public function toggleApproved(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_approved' => !$testimonial->is_approved,
        ]);

        return redirect()->back()
            ->with('success', 'Testimonial approval status updated.');
    }

    /**
     * Toggle featured status (admin).
     */
    public function toggleFeatured(Testimonial $testimonial)
    {
        $testimonial->update([
            'is_featured' => !$testimonial->is_featured,
        ]);

        return redirect()->back()
            ->with('success', 'Testimonial featured status updated.');
    }
}
