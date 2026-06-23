@extends('layouts.app')

@section('title', 'Submit Enquiry')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title text-center mb-4">Submit Safari Enquiry</h1>
                        <p class="text-center text-muted mb-4">Fill in the form below and our team will contact you with a customized quote.</p>

                        <form action="{{ route('enquiry.store') }}" method="POST">
                            @csrf
                            
                            @if(auth()->check())
                            <div class="alert alert-info">
                                <i class="fas fa-user-circle me-2"></i>
                                Submitting enquiry as <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="full_name" class="form-control" value="{{ auth()->check() ? auth()->user()->name : old('full_name') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" class="form-control" value="{{ auth()->check() ? auth()->user()->email : old('email') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone *</label>
                                    <input type="text" name="phone" class="form-control" value="{{ auth()->check() ? auth()->user()->phone : old('phone') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country *</label>
                                    <input type="text" name="country" class="form-control" value="{{ auth()->check() ? auth()->user()->country : old('country') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Interested Package</label>
                                <select name="package_id" class="form-select">
                                    <option value="">Select a package (optional)</option>
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->title }} - ${{ number_format($package->price, 2) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Number of Adults *</label>
                                    <input type="number" name="adults" class="form-control" value="1" min="1" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Number of Children</label>
                                    <input type="number" name="children" class="form-control" value="0" min="0">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Preferred Travel Date</label>
                                    <input type="date" name="travel_date" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Duration (Days)</label>
                                    <input type="number" name="duration" class="form-control" placeholder="Optional">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Budget Range</label>
                                <select name="budget" class="form-select">
                                    <option value="">Select budget range</option>
                                    <option value="1000-2000">$1,000 - $2,000</option>
                                    <option value="2000-3000">$2,000 - $3,000</option>
                                    <option value="3000-5000">$3,000 - $5,000</option>
                                    <option value="5000-10000">$5,000 - $10,000</option>
                                    <option value="10000+">$10,000+</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Additional Message</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="Tell us about your safari preferences, special requirements, or any questions..."></textarea>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="privacy" required>
                                    <label class="form-check-label" for="privacy">
                                        I agree to the privacy policy and terms of service
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">Submit Enquiry</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection