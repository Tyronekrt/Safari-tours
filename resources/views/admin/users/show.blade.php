@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>User Details</h1>
        <div>
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Users
            </a>
        </div>
    </div>

    <!-- User Information -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" class="rounded-circle mb-3" alt="{{ $user->name }}" style="width: 120px; height: 120px;">
                    @else
                        <div class="bg-secondary rounded-circle mb-3 d-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px;">
                            <span class="text-white display-6">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    @endif
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                    <p class="text-muted small">{{ $user->phone }}</p>
                    <p class="text-muted small">{{ $user->country }}</p>
                    
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{ ucfirst($role->name) }}</span>
                    @endforeach
                    
                    <div class="mt-3">
                        @if($user->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statistics</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <h3>{{ $user->enquiries->count() }}</h3>
                                <p class="text-muted">Enquiries Submitted</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h3>{{ $user->assignedEnquiries->count() }}</h3>
                                <p class="text-muted">Assigned Enquiries</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h3>{{ $user->enquiryNotes->count() }}</h3>
                                <p class="text-muted">Notes Added</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Account Information</h5>
                    <table class="table">
                        <tr>
                            <th>Member Since:</th>
                            <td>{{ $user->created_at->format('F d, Y') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $user->updated_at->format('F d, Y') }}</td>
                        </tr>
                        @if($user->deleted_at)
                        <tr>
                            <th>Deleted At:</th>
                            <td>{{ $user->deleted_at->format('F d, Y') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User's Enquiries -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Enquiries by {{ $user->name }}</h5>
            @if($user->enquiries->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package</th>
                                <th>Status</th>
                                <th>Submitted Date</th>
                                <th>Travel Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->enquiries as $enquiry)
                                <tr>
                                    <td>#{{ $enquiry->id }}</td>
                                    <td>
                                        @if($enquiry->package)
                                            {{ $enquiry->package->title }}
                                        @else
                                            No package
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge status-{{ $enquiry->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $enquiry->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $enquiry->travel_date ? $enquiry->travel_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="btn btn-sm btn-primary">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">This user hasn't submitted any enquiries yet.</p>
            @endif
        </div>
    </div>
@endsection
