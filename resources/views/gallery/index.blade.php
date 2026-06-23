@extends('layouts.app')

@section('title', 'Photo Gallery')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">Photo Gallery</h1>
            <p class="lead text-muted">Explore the breathtaking scenery and wildlife of Africa</p>
        </div>

        <div class="row">
            @forelse($galleries as $gallery)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ str_starts_with($gallery->image, 'http') ? $gallery->image : asset('storage/' . $gallery->image) }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $gallery->title }}</h5>
                            @if($gallery->location)
                                <p class="card-text text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $gallery->location }}</p>
                            @endif
                            @if($gallery->description)
                                <p class="card-text">{{ Str::limit($gallery->description, 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>No photos available yet</h4>
                        <p>Check back soon for amazing safari photos!</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
@endsection