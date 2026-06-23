@extends('layouts.app')

@section('title', 'Safari Packages')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="display-4 fw-bold">Safari Packages</h1>
                <p class="lead">Discover our carefully curated safari experiences</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('packages.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="category" class="form-select">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Package Grid -->
        <div class="row">
            @forelse($packages as $package)
                <div class="col-md-4 mb-4">
                    <div class="card package-card h-100">
                        @if($package->featured_image)
                            <img src="{{ asset('storage/' . $package->featured_image) }}" class="card-img-top" alt="{{ $package->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                <span class="text-white">No Image</span>
                            </div>
                        @endif
                        @if($package->is_featured)
                            <span class="badge bg-warning position-absolute top-0 end-0 m-2">Featured</span>
                        @endif
                        <div class="card-body">
                            @if($package->category)
                                <span class="badge bg-info mb-2">{{ $package->category->name }}</span>
                            @endif
                            <h5 class="card-title">{{ $package->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($package->short_desc, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                @if($package->duration)
                                    <span class="badge bg-info"><i class="fas fa-clock me-1"></i>{{ $package->duration }} Days</span>
                                @endif
                                @if($package->price)
                                    <span class="badge bg-success">${{ number_format($package->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0">
                            <a href="{{ route('packages.show', $package->slug) }}" class="btn btn-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>No packages found</h4>
                        <p>Check back later for new safari packages.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($packages->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $packages->links() }}
            </div>
        @endif
    </div>
@endsection