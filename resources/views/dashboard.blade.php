@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">My Profile</h5>
                        <div class="mb-3">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" class="rounded-circle" alt="Profile" style="width: 100px; height: 100px;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; margin: 0 auto;">
                                    <span class="text-white">No Avatar</span>
                                </div>
                            @endif
                        </div>
                        <h4>{{ auth()->user()->name }}</h4>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <p class="text-muted small">{{ auth()->user()->country }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Update Profile</h5>
                        <form action="{{ route('dashboard.update-profile') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" value="{{ auth()->user()->country }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">My Enquiries</h5>
                            <a href="{{ route('enquiry.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Submit New Enquiry
                            </a>
                        </div>
                        @if($enquiries->count() > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Package</th>
                                            <th>Status</th>
                                            <th>Submitted Date</th>
                                            <th>Travel Date</th>
                                            <th>Adults/Children</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($enquiries as $enquiry)
                                            <tr>
                                                <td>
                                                    @if($enquiry->package)
                                                        {{ $enquiry->package->title }}
                                                    @else
                                                        No package selected
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge status-{{ $enquiry->status }}">
                                                        {{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}
                                                    </span>
                                                </td>
                                                <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                                <td>{{ $enquiry->travel_date ? $enquiry->travel_date->format('Y-m-d') : 'N/A' }}</td>
                                                <td>{{ $enquiry->adults }}/{{ $enquiry->children }}</td>
                                                <td>
                                                    <a href="{{ route('packages.show', $enquiry->package ? $enquiry->package->slug : '#') }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="#" class="btn btn-outline-primary">View All Enquiries</a>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-envelope-open-text fa-3x text-muted mb-3"></i>
                                <p class="text-muted">You haven't submitted any enquiries yet.</p>
                                <a href="{{ route('enquiry.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> Submit Your First Enquiry
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection