@extends('layouts.admin')

@section('title', 'Contacts Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Contacts</h1>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.contacts.index') }}">
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
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by name, email, subject" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100">Apply</button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary w-100">Clear Filters</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr class="{{ $contact->read_at ? '' : 'table-primary' }}">
                                <td>#{{ $contact->id }}</td>
                                <td>
                                    <strong>{{ $contact->name }}</strong>
                                    @if($contact->phone)
                                        <p class="mb-0 small text-muted">{{ $contact->phone }}</p>
                                    @endif
                                </td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ Str::limit($contact->subject, 30) }}</td>
                                <td>
                                    <span class="badge status-{{ $contact->status }}">
                                        {{ ucfirst($contact->status) }}
                                    </span>
                                    @if(!$contact->read_at)
                                        <span class="badge bg-danger">New</span>
                                    @endif
                                </td>
                                <td>{{ $contact->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display: inline;" data-delete-form data-confirm-message="Are you sure you want to delete this contact?">
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
                                <td colspan="7" class="text-center">No contacts found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($contacts->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $contacts->links() }}
        </div>
    @endif
@endsection