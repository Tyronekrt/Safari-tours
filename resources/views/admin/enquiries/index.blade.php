@extends('layouts.admin')

@section('title', 'Enquiries Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Enquiries</h1>
        <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-filter me-1"></i> Clear Filters
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.enquiries.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Assigned To</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">All Agents</option>
                            @foreach($salesAgents as $agent)
                                <option value="{{ $agent->id }}" {{ request('assigned_to') == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Apply</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Enquiries Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Travel Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enquiries as $enquiry)
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
                                <td>
                                    @if($enquiry->assignedTo)
                                        {{ $enquiry->assignedTo->name }}
                                    @else
                                        <span class="text-muted">Unassigned</span>
                                    @endif
                                </td>
                                <td>{{ $enquiry->travel_date ? $enquiry->travel_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.enquiries.destroy', $enquiry) }}" method="POST" class="d-inline" data-delete-form data-confirm-message="Are you sure you want to delete this enquiry?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No enquiries found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($enquiries->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $enquiries->links() }}
        </div>
    @endif
@endsection