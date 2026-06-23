@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h1 class="display-4 fw-bold">About Us</h1>
                <p class="lead">Your trusted partner for unforgettable African safari experiences</p>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-6">
                <h3>Our Story</h3>
                <p>Safari Tours has been operating since 2010, providing unforgettable wildlife experiences to travelers from around the world. Our passionate team of expert guides and wildlife enthusiasts is dedicated to creating personalized safari adventures that exceed expectations.</p>
                <p>We believe in responsible tourism that supports local communities and wildlife conservation. Every safari we design contributes to protecting Africa's magnificent wildlife and preserving their natural habitats for future generations.</p>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body bg-light">
                        <h3 class="card-title">Our Mission</h3>
                        <p class="card-text">To provide exceptional safari experiences that connect people with Africa's incredible wildlife and cultures while supporting conservation and sustainable tourism practices.</p>
                        
                        <h4 class="mt-4">Our Values</h4>
                        <ul>
                            <li><strong>Excellence:</strong> We strive for excellence in every aspect of our service</li>
                            <li><strong>Conservation:</strong> We support wildlife conservation and sustainable tourism</li>
                            <li><strong>Cultural Respect:</strong> We honor and respect local cultures and traditions</li>
                            <li><strong>Safety First:</strong> We prioritize the safety and well-being of our guests</li>
                            <li><strong>Sustainability:</strong> We minimize our environmental footprint</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-12">
                <h3 class="text-center mb-4">Why Choose Us?</h3>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                        <h4>Expert Team</h4>
                        <p>Our guides have decades of experience and deep knowledge of African wildlife and ecosystems.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-shield-alt fa-3x mb-3 text-success"></i>
                        <h4>Safe Travel</h4>
                        <p>We maintain the highest safety standards with well-maintained vehicles and comprehensive insurance.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-globe-africa fa-3x mb-3 text-warning"></i>
                        <h4>Sustainable Tourism</h4>
                        <p>We're committed to responsible tourism that benefits local communities and wildlife conservation.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <div class="card bg-primary text-white">
                    <div class="card-body py-5">
                        <h2 class="card-title mb-3">Ready to Start Your Adventure?</h2>
                        <p class="card-text mb-4">Join thousands of satisfied travelers who have experienced the magic of Africa with us.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('packages.index') }}" class="btn btn-light btn-lg">Browse Packages</a>
                            <a href="{{ route('enquiry.create') }}" class="btn btn-outline-light btn-lg">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection