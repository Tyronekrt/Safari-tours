@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Dashboard</h1>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Enquiries</h5>
                    <p class="card-text display-4">{{ $totalEnquiries }}</p>
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
                    <h5 class="card-title">Confirmed</h5>
                    <p class="card-text display-4">{{ $confirmedBookings }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Enquiry Status Distribution -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Enquiry Status Distribution</h5>
                </div>
                <div class="card-body">
                    <div class="progress mb-2">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $totalEnquiries > 0 ? ($enquiriesByStatus['new'] / $totalEnquiries * 100) : 0 }}%">
                            New: {{ $enquiriesByStatus['new'] }}
                        </div>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $totalEnquiries > 0 ? ($enquiriesByStatus['contacted'] / $totalEnquiries * 100) : 0 }}%">
                            Contacted: {{ $enquiriesByStatus['contacted'] }}
                        </div>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-purple" role="progressbar" style="width: {{ $totalEnquiries > 0 ? ($enquiriesByStatus['quotation_sent'] / $totalEnquiries * 100) : 0 }}%; background-color: #6f42c1;">
                            Quotation Sent: {{ $enquiriesByStatus['quotation_sent'] }}
                        </div>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-orange" role="progressbar" style="width: {{ $totalEnquiries > 0 ? ($enquiriesByStatus['negotiation'] / $totalEnquiries * 100) : 0 }}%; background-color: #fd7e14;">
                            Negotiation: {{ $enquiriesByStatus['negotiation'] }}
                        </div>
                    </div>
                    <div class="progress mb-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalEnquiries > 0 ? ($enquiriesByStatus['confirmed'] / $totalEnquiries * 100) : 0 }}%">
                            Confirmed: {{ $enquiriesByStatus['confirmed'] }}
                        </div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $totalEnquiries > 0 ? ($enquiriesByStatus['cancelled'] / $totalEnquiries * 100) : 0 }}%">
                            Cancelled: {{ $enquiriesByStatus['cancelled'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Conversion Rate</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h1 class="display-1 fw-bold">{{ number_format($conversionRate, 1) }}%</h1>
                        <p class="text-muted">Confirmed bookings out of total enquiries</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Enquiries -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Enquiries</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($recentEnquiries as $enquiry)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $enquiry->full_name }}</strong>
                                        <p class="mb-0 small text-muted">{{ $enquiry->email }}</p>
                                    </div>
                                    <span class="badge status-{{ $enquiry->status }}">{{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Users</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <p class="mb-0 small text-muted">{{ $user->email }}</p>
                                    </div>
                                    <span class="badge bg-secondary">{{ $user->roles->pluck('name')->first() ?? 'Customer' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection