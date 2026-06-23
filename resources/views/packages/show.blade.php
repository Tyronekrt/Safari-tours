@extends('layouts.app')

@section('title', $package->title)

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <!-- Package Hero -->
                @if($package->featured_image)
                    <img src="{{ asset('storage/' . $package->featured_image) }}" class="img-fluid rounded mb-4" alt="{{ $package->title }}">
                @endif

                <h1 class="display-4 fw-bold mb-3">{{ $package->title }}</h1>
                
                <div class="mb-4">
                    @if($package->duration)
                        <span class="badge bg-info me-2"><i class="fas fa-clock me-1"></i>{{ $package->duration }} Days</span>
                    @endif
                    @if($package->price)
                        <span class="badge bg-success me-2">${{ number_format($package->price, 2) }}</span>
                    @endif
                    @if($package->location)
                        <span class="badge bg-secondary me-2"><i class="fas fa-map-marker-alt me-1"></i>{{ $package->location }}</span>
                    @endif
                </div>

                @if($package->full_desc)
                    <div class="mb-4">
                        <h3>Description</h3>
                        <p>{!! $package->full_desc !!}</p>
                    </div>
                @endif

                @if($package->highlights && count($package->highlights))
                    <div class="mb-4">
                        <h3>Highlights</h3>
                        <ul>
                            @foreach($package->highlights as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($package->inclusions && count($package->inclusions))
                    <div class="mb-4">
                        <h3>Inclusions</h3>
                        <ul>
                            @foreach($package->inclusions as $inclusion)
                                <li>{{ $inclusion }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Enquiry Form -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>Book This Safari</h3>
                        <form action="{{ route('enquiry.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="package_id" value="{{ $package->id }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Number of Adults</label>
                                    <input type="number" name="adults" class="form-control" value="1" min="1" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Number of Children</label>
                                    <input type="number" name="children" class="form-control" value="0" min="0">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Travel Date</label>
                                <input type="date" name="travel_date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit Enquiry</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Package Details</h5>
                        <ul class="list-unstyled">
                            @if($package->duration)
                                <li class="mb-2"><i class="fas fa-clock me-2"></i>{{ $package->duration }} Days</li>
                            @endif
                            @if($package->price)
                                <li class="mb-2"><i class="fas fa-dollar-sign me-2"></i>${{ number_format($package->price, 2) }}</li>
                            @endif
                            @if($package->location)
                                <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>{{ $package->location }}</li>
                            @endif
                            @if($package->category)
                                <li class="mb-2"><i class="fas fa-folder me-2"></i>{{ $package->category->name }}</li>
                            @endif
                        </ul>
                    </div>
                </div>

                @if($relatedPackages->count() > 0)
                    <div class="card">
                        <div class="card-body">
                            <h5>Related Packages</h5>
                            @foreach($relatedPackages as $related)
                                <div class="mb-3">
                                    <a href="{{ route('packages.show', $related->slug) }}">
                                        {{ $related->title }}
                                    </a>
                                    @if($related->price)
                                        <span class="badge bg-success">${{ number_format($related->price, 2) }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection