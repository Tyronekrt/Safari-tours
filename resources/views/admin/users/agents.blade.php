@extends('layouts.admin')

@section('title', 'Sales Agents Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Sales Agents</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Agent
        </a>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.agents') }}">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <a href="{{ route('admin.users.agents') }}" class="btn btn-outline-secondary w-100">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Agents Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Agent</th>
                            <th>Status</th>
                            <th>Enquiries</th>
                            <th>Assigned</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agents as $agent)
                            <tr>
                                <td>#{{ $agent->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($agent->avatar)
                                            <img src="{{ $agent->avatar }}" class="rounded-circle me-2" alt="{{ $agent->name }}" style="width: 40px; height: 40px;">
                                        @else
                                            <div class="bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <span class="text-white small">{{ substr($agent->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $agent->name }}</strong>
                                            <p class="mb-0 small text-muted">{{ $agent->email }}</p>
                                            <p class="mb-0 small text-muted">{{ $agent->phone }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($agent->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $agent->enquiries->count() }}</td>
                                <td>{{ $agent->assignedEnquiries->count() }}</td>
                                <td>{{ $agent->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.show', $agent->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $agent->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.toggle-status', $agent->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-{{ $agent->is_active ? 'danger' : 'success' }}">
                                            <i class="fas fa-{{ $agent->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $agent->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No agents found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($agents->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $agents->links() }}
        </div>
    @endif
@endsection