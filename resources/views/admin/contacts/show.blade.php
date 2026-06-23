@extends('layouts.admin')

@section('title', 'Contact Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Contact #{{ $contact->id }}</h1>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Contacts
        </a>
    </div>

    <!-- Contact Details -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Name:</strong>
                            <p class="mb-0">{{ $contact->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong>
                            <p class="mb-0">{{ $contact->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Phone:</strong>
                            <p class="mb-0">{{ $contact->phone ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Subject:</strong>
                            <p class="mb-0">{{ $contact->subject }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Message:</strong>
                            <p class="mb-0">{{ $contact->message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Status</h5>
                </div>
                <div class="card-body">
                    <span class="badge status-{{ $contact->status }} fs-5">
                        {{ ucfirst($contact->status) }}
                    </span>
                    <p class="mt-3 mb-0 text-muted">
                        Received: {{ $contact->created_at->format('Y-m-d H:i') }}
                    </p>
                    @if($contact->read_at)
                        <p class="mb-0 text-muted">
                            Read: {{ $contact->read_at->format('Y-m-d H:i') }}
                        </p>
                    @endif
                    @if($contact->replied_at)
                        <p class="mb-0 text-muted">
                            Replied: {{ $contact->replied_at->format('Y-m-d H:i') }}
                        </p>
                        <p class="mb-0 text-muted">
                            By: {{ $contact->replier->name }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Notes -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Admin Notes</h5>
        </div>
        <div class="card-body">
            @if($contact->admin_notes)
                <p>{{ $contact->admin_notes }}</p>
            @else
                <p class="text-muted">No admin notes added yet.</p>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <form action="{{ route('admin.contacts.status', $contact) }}" method="POST">
                        @csrf
                        <label class="form-label">Update Status</label>
                        <select name="status" class="form-select mb-2">
                            @foreach(['new', 'read', 'replied', 'closed'] as $status)
                                <option value="{{ $status }}" {{ $contact->status == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        <textarea name="admin_notes" class="form-control mb-2" placeholder="Add admin notes (optional)">{{ $contact->admin_notes }}</textarea>
                        <button type="submit" class="btn btn-success w-100">Update Status</button>
                    </form>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="d-grid gap-2">
                        @if($contact->status !== 'replied')
                        <form action="{{ route('admin.contacts.mark-replied', $contact) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-reply me-1"></i> Mark as Replied
                            </button>
                        </form>
                        @endif
                        @if($contact->status !== 'closed')
                        <form action="{{ route('admin.contacts.mark-closed', $contact) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="fas fa-check me-1"></i> Mark as Closed
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection