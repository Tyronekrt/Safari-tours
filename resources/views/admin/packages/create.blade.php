@extends('layouts.admin')

@section('title', isset($package) ? 'Edit Package' : 'Create Package')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ isset($package) ? 'Edit Package' : 'Create Package' }}</h1>
        <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Packages
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ isset($package) ? route('admin.packages.update', $package) : route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
                @if(isset($package))
                    @method('PUT')
                @endif
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $package->title ?? '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $package->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Featured Image</label>
                    <input type="file" name="featured_image" class="form-control" accept="image/*">
                    @if(isset($package) && $package->featured_image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $package->featured_image) }}" alt="Current image" style="max-height: 200px;">
                            <small class="text-muted d-block">Current image</small>
                        </div>
                    @endif
                    <small class="text-muted">Recommended size: 1200x800px. Max size: 2MB.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Short Description *</label>
                    <textarea name="short_desc" class="form-control" rows="2" required>{{ old('short_desc', $package->short_desc ?? '') }}</textarea>
                    <small class="text-muted">Maximum 500 characters</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Full Description</label>
                    <textarea name="full_desc" class="form-control" rows="6">{{ old('full_desc', $package->full_desc ?? '') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Duration (Days)</label>
                        <input type="number" name="duration" class="form-control" value="{{ old('duration', $package->duration ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $package->price ?? '') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="{{ old('location', $package->location ?? '') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Destinations</label>
                    <select name="destinations[]" class="form-select" multiple>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination->id }}" 
                                @if(isset($package) && $package->destinations->contains($destination->id)) selected @endif>
                                {{ $destination->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_featured" value="0">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $package->is_featured ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Featured Package</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_published" value="0">
                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $package->is_published ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">Published</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $package->meta_title ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $package->meta_description ?? '') }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($package) ? 'Update Package' : 'Create Package' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection