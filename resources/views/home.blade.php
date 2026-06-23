@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Experience the Magic of African Safaris</h1>
            <p class="lead my-4">Unforgettable wildlife encounters, breathtaking landscapes, and authentic cultural experiences</p>
            <a href="{{ route('packages.index') }}" class="btn btn-primary btn-lg me-3">Explore Packages</a>
            <a href="{{ route('enquiry.create') }}" class="btn btn-outline-light btn-lg">Get Quote</a>
        </div>
    </section>

    <!-- Featured Packages -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Featured Safari Packages</h2>
                <p class="lead">Handpicked experiences for your perfect African adventure</p>
            </div>
            <div class="row">
                @foreach($featuredPackages as $package)
                    <div class="col-md-4 mb-4">
                        <div class="card package-card h-100">
                            @if($package->featured_image)
                                <img src="{{ asset('storage/' . $package->featured_image) }}" class="card-img-top" alt="{{ $package->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-white">No Image</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $package->title }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($package->short_desc, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
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
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('packages.index') }}" class="btn btn-outline-primary">View All Packages</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Why Choose Safari Tours</h2>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4 text-center">
                    <div class="p-4">
                        <i class="fas fa-award fa-3x mb-3 text-primary"></i>
                        <h4>Expert Guides</h4>
                        <p class="text-muted">Experienced local guides with deep knowledge of wildlife and culture</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="p-4">
                        <i class="fas fa-shield-alt fa-3x mb-3 text-success"></i>
                        <h4>Safe & Secure</h4>
                        <p class="text-muted">Your safety is our priority with well-maintained vehicles and equipment</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <div class="p-4">
                        <i class="fas fa-heart fa-3x mb-3 text-danger"></i>
                        <h4>Unforgettable Memories</h4>
                        <p class="text-muted">Create lasting memories with our carefully crafted safari experiences</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Carousel -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">What Our Clients Say</h2>
                <p class="lead">Real experiences from our satisfied safari adventurers</p>
            </div>
            @php
                $testimonials = \App\Models\Testimonial::approved()->featured()->ordered()->take(5)->get();
                if($testimonials->count() < 3) {
                    $testimonials = \App\Models\Testimonial::approved()->ordered()->take(5)->get();
                }
            @endphp
            @if($testimonials->count() > 0)
                <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($testimonials as $index => $testimonial)
                            <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" {{ $index === 0 ? 'aria-current="true"' : '' }} aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach($testimonials as $index => $testimonial)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="card bg-light">
                                                <div class="card-body text-center p-5">
                                                    @if($testimonial->customer_image)
                                                        <img src="{{ asset('storage/' . $testimonial->customer_image) }}" class="rounded-circle mb-3" alt="{{ $testimonial->customer_name }}" style="width: 80px; height: 80px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-3 mx-auto" style="width: 80px; height: 80px;">
                                                            <span class="fs-4">{{ substr($testimonial->customer_name, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                    <h5 class="card-title">{{ $testimonial->customer_name }}</h5>
                                                    @if($testimonial->package_name)
                                                        <p class="text-muted small mb-3"><i class="fas fa-safari me-1"></i>{{ $testimonial->package_name }}</p>
                                                    @endif
                                                    <p class="card-text lead fst-italic">"{{ $testimonial->content }}"</p>
                                                    <div class="mb-3">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $testimonial->rating)
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    @if($testimonial->travel_date)
                                                        <p class="text-muted small">Traveled: {{ $testimonial->travel_date->format('F Y') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h4>No testimonials yet</h4>
                    <p>Be the first to share your safari experience!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="display-5 fw-bold">Ready for Your Safari Adventure?</h2>
            <p class="lead my-4">Contact us today to start planning your dream African safari</p>
            <a href="{{ route('enquiry.create') }}" class="btn btn-light btn-lg">Get a Free Quote</a>
        </div>
    </section>
@endsection