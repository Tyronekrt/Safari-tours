<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the gallery (public).
     */
    public function index()
    {
        $galleries = Gallery::active()->ordered()->paginate(12);

        return view('gallery.index', compact('galleries'));
    }

    /**
     * Display a listing of the gallery (admin).
     */
    public function adminIndex()
    {
        $galleries = Gallery::latest()->paginate(20);

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new gallery item (admin).
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created gallery item in storage (admin).
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'location' => 'nullable|string|max:255',
                'is_active' => 'nullable|boolean',
                'display_order' => 'nullable|integer',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('gallery', 'public');
            }

            Gallery::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
                'location' => $request->location,
                'is_active' => $request->boolean('is_active', true),
                'display_order' => $request->display_order ?? 0,
            ]);

            return redirect()->route('admin.gallery.index')
                ->with('success', 'Gallery item created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.gallery.create')
                ->with('error', 'Error creating gallery item: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified gallery item (admin).
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified gallery item in storage (admin).
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'location' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer',
        ]);

        $imagePath = $gallery->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gallery->image) {
                \Storage::disk('public')->delete($gallery->image);
            }
            $imagePath = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'location' => $request->location,
            'is_active' => $request->boolean('is_active', true),
            'display_order' => $request->display_order ?? 0,
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery item updated successfully.');
    }

    /**
     * Remove the specified gallery item from storage (admin).
     */
    public function destroy(Gallery $gallery)
    {
        // Delete image if exists
        if ($gallery->image) {
            \Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery item deleted successfully.');
    }

    /**
     * Toggle active status (admin).
     */
    public function toggleActive(Gallery $gallery)
    {
        $gallery->update([
            'is_active' => !$gallery->is_active,
        ]);

        return redirect()->back()
            ->with('success', 'Gallery item status updated.');
    }
}
