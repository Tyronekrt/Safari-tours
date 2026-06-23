@extends('layouts.admin')

@section('title', 'Agent Dashboard')

@section('content')
    <h1 class="mb-4">Welcome, {{ auth()->user()->name }}!</h1>
    <p class="text-muted mb-4">Here are your assigned enquiries and performance metrics.</p>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Assigned</h5>
                    <p class="card-text display-4">{{ $totalAssigned }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">New Enquiries</h5>
                    <p class="card-text display-4">{{ $newEnquiries }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Contacted</h5>
                    <p class="card-text display-4">{{ $contacted }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Confirmed</h5>
                    <p class="card-text display-4">{{ $confirmed }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned Enquiries -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">My Assigned Enquiries</h5>
        </div>
        <div class="card-body">
            @if($assignedEnquiries->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Package</th>
                                <th>Status</th>
                                <th>Travel Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignedEnquiries as $enquiry)
                                <tr>
                                    <td>#{{ $enquiry->id }}</td>
                                    <td>
                                        <strong>{{ $enquiry->full_name }}</strong>
                                        <p class="mb-0 small text-muted">{{ $enquiry->email }}</p>
                                        <p class="mb-0 small text-muted">{{ $enquiry->phone }}</p>
                                    </td>
                                    <td>
                                        @if($enquiry->package)
                                            {{ $enquiry->package->title }}
                                        @else
                                            <span class="text-muted">No package</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge status-{{ $enquiry->status }}">
                                            {{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $enquiry->travel_date ? $enquiry->travel_date->format('Y-m-d') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($assignedEnquiries->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $assignedEnquiries->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">You haven't been assigned any enquiries yet.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
