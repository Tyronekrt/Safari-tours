<?php

namespace App\Http\Controllers;

use App\Models\SafariPackage;
use App\Models\PackageCategory;
use App\Models\Destination;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the packages (public).
     */
    public function index()
    {
        $packages = SafariPackage::published()
            ->with(['category', 'destinations'])
            ->paginate(12);

        $categories = PackageCategory::where('is_active', true)->get();

        return view('packages.index', compact('packages', 'categories'));
    }

    /**
     * Display the specified package (public).
     */
    public function show($slug)
    {
        $package = SafariPackage::published()
            ->with(['category', 'destinations'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $package->increment('views_count');

        $relatedPackages = SafariPackage::published()
            ->where('category_id', $package->category_id)
            ->where('id', '!=', $package->id)
            ->limit(3)
            ->get();

        return view('packages.show', compact('package', 'relatedPackages'));
    }

    /**
     * Display a listing of the packages (admin).
     */
    public function adminIndex()
    {
        $packages = SafariPackage::with(['category', 'destinations'])
            ->latest()
            ->paginate(20);

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new package (admin).
     */
    public function create()
    {
        $categories = PackageCategory::where('is_active', true)->get();
        $destinations = Destination::active()->get();

        return view('admin.packages.create', compact('categories', 'destinations'));
    }

    /**
     * Store a newly created package in storage (admin).
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'category_id' => 'nullable|exists:package_categories,id',
                'short_desc' => 'required|string|max:500',
                'full_desc' => 'nullable|string',
                'duration' => 'nullable|integer',
                'price' => 'nullable|numeric',
                'location' => 'nullable|string|max:255',
                'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'destinations' => 'array',
                'is_featured' => 'nullable|boolean',
                'is_published' => 'nullable|boolean',
            ]);

            $featuredImagePath = null;
            if ($request->hasFile('featured_image')) {
                $featuredImagePath = $request->file('featured_image')->store('packages', 'public');
            }

            $package = SafariPackage::create([
                'title' => $request->title,
                'slug' => \Str::slug($request->title),
                'category_id' => $request->category_id,
                'featured_image' => $featuredImagePath,
                'short_desc' => $request->short_desc,
                'full_desc' => $request->full_desc,
                'duration' => $request->duration,
                'price' => $request->price,
                'location' => $request->location,
                'is_featured' => $request->boolean('is_featured'),
                'is_published' => $request->boolean('is_published'),
                'published_at' => $request->boolean('is_published') ? now() : null,
            ]);

            if ($request->has('destinations')) {
                $package->destinations()->sync($request->destinations);
            }

            return redirect()->route('admin.packages.index')
                ->with('success', 'Package created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.packages.create')
                ->with('error', 'Error creating package: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified package (admin).
     */
    public function edit(SafariPackage $package)
    {
        $categories = PackageCategory::where('is_active', true)->get();
        $destinations = Destination::active()->get();

        return view('admin.packages.create', compact('package', 'categories', 'destinations'));
    }

    /**
     * Update the specified package in storage (admin).
     */
    public function update(Request $request, SafariPackage $package)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:package_categories,id',
            'short_desc' => 'required|string|max:500',
            'full_desc' => 'nullable|string',
            'duration' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'location' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'destinations' => 'array',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        $featuredImagePath = $package->featured_image;
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($package->featured_image) {
                \Storage::disk('public')->delete($package->featured_image);
            }
            $featuredImagePath = $request->file('featured_image')->store('packages', 'public');
        }

        $package->update([
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'category_id' => $request->category_id,
            'featured_image' => $featuredImagePath,
            'short_desc' => $request->short_desc,
            'full_desc' => $request->full_desc,
            'duration' => $request->duration,
            'price' => $request->price,
            'location' => $request->location,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
            'published_at' => $request->boolean('is_published') ?
                ($package->published_at ?? now()) : null,
        ]);

        if ($request->has('destinations')) {
            $package->destinations()->sync($request->destinations);
        }

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package from storage (admin).
     */
    public function destroy(SafariPackage $package)
    {
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    /**
     * Toggle featured status (admin).
     */
    public function toggleFeatured(SafariPackage $package)
    {
        $package->update([
            'is_featured' => !$package->is_featured,
            'featured_until' => $package->is_featured ? null : now()->addMonths(1),
        ]);

        return redirect()->back()
            ->with('success', 'Package featured status updated.');
    }

    /**
     * Toggle published status (admin).
     */
    public function togglePublished(SafariPackage $package)
    {
        $package->update([
            'is_published' => !$package->is_published,
            'published_at' => !$package->is_published ? now() : null,
        ]);

        return redirect()->back()
            ->with('success', 'Package published status updated.');
    }
}
