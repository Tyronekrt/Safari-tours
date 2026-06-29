@extends('layouts.admin')

@section('title', 'Enquiry Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Enquiry #{{ $enquiry->id }}</h1>
        <a href="{{ route('admin.enquiries.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Enquiries
        </a>
    </div>

    <!-- Enquiry Details -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Full Name:</strong>
                            <p class="mb-0">{{ $enquiry->full_name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Email:</strong>
                            <p class="mb-0">{{ $enquiry->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Phone:</strong>
                            <p class="mb-0">{{ $enquiry->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Country:</strong>
                            <p class="mb-0">{{ $enquiry->country }}</p>
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
                    <span class="badge status-{{ $enquiry->status }} fs-5">
                        {{ ucfirst(str_replace('_', ' ', $enquiry->status)) }}
                    </span>
                    <p class="mt-3 mb-0 text-muted">
                        @if($enquiry->last_contacted_at)
                            Last contacted: {{ $enquiry->last_contacted_at->format('Y-m-d H:i') }}
                        @else
                            Never contacted
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Package Details -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Package Details</h5>
                </div>
                <div class="card-body">
                    @if($enquiry->package)
                        <h6>{{ $enquiry->package->title }}</h6>
                        <p class="mb-0">{{ $enquiry->package->short_desc }}</p>
                        <div class="mt-2">
                            @if($enquiry->package->duration)
                                <span class="badge bg-info me-2">{{ $enquiry->package->duration }} Days</span>
                            @endif
                            @if($enquiry->package->price)
                                <span class="badge bg-success">${{ number_format($enquiry->package->price, 2) }}</span>
                            @endif
                        </div>
                    @else
                        <p class="mb-0 text-muted">No package selected</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Travel Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <strong>Adults:</strong>
                            <p class="mb-0">{{ $enquiry->adults }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <strong>Children:</strong>
                            <p class="mb-0">{{ $enquiry->children }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <strong>Travel Date:</strong>
                            <p class="mb-0">{{ $enquiry->travel_date ? $enquiry->travel_date->format('Y-m-d') : 'N/A' }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <strong>Duration:</strong>
                            <p class="mb-0">{{ $enquiry->duration ? $enquiry->duration . ' days' : 'N/A' }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Budget:</strong>
                            <p class="mb-0">{{ $enquiry->budget ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message -->
    @if($enquiry->message)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Message from Customer</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $enquiry->message }}</p>
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <form action="{{ route('admin.enquiries.assign', $enquiry) }}" method="POST">
                        @csrf
                        <label class="form-label">Assign to Sales Agent</label>
                        <select name="assigned_to" class="form-select mb-2">
                            <option value="">Select Agent</option>
                            @foreach($salesAgents as $agent)
                                <option value="{{ $agent->id }}" {{ $enquiry->assigned_to == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary w-100">Assign</button>
                    </form>
                </div>
                <div class="col-md-4 mb-3">
                    <form action="{{ route('admin.enquiries.status', $enquiry) }}" method="POST">
                        @csrf
                        <label class="form-label">Update Status</label>
                        <select name="status" class="form-select mb-2">
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ $enquiry->status == $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="notes" class="form-control mb-2" placeholder="Add notes (optional)">
                        <button type="submit" class="btn btn-success w-100">Update Status</button>
                    </form>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-grid gap-2">
                        @if($enquiry->status !== 'confirmed')
                        <form action="{{ route('admin.enquiries.approve', $enquiry) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Are you sure you want to approve this enquiry?')">
                                <i class="fas fa-check me-1"></i> Approve Enquiry
                            </button>
                        </form>
                        @endif
                        @if($enquiry->status !== 'cancelled')
                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times me-1"></i> Reject Enquiry
                        </button>
                        @endif
                        <form action="{{ route('admin.enquiries.reminder', $enquiry) }}" method="POST">
                            @csrf
                            <label class="form-label small text-muted">Set Follow-up Reminder</label>
                            <input type="date" name="reminder_date" class="form-control mb-2" required>
                            <input type="text" name="notes" class="form-control mb-2" placeholder="Reminder notes">
                            <button type="submit" class="btn btn-warning w-100">Set Reminder</button>
                        </form>
                        <form action="{{ route('admin.enquiries.destroy', $enquiry) }}" method="POST" data-delete-form data-confirm-message="Are you sure you want to delete this enquiry?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100 mt-2">
                                <i class="fas fa-trash me-1"></i> Delete Enquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Enquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.enquiries.reject', $enquiry) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rejection Reason *</label>
                            <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Please provide a reason for rejection"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Enquiry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Status History -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Status History</h5>
        </div>
        <div class="card-body">
            <div class="timeline">
                @foreach($enquiry->statusHistory->sortByDesc('changed_at') as $history)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <strong>{{ ucfirst(str_replace('_', ' ', $history->status)) }}</strong>
                            <small class="text-muted">{{ $history->changed_at->format('Y-m-d H:i') }}</small>
                        </div>
                        <p class="mb-0 small text-muted">
                            Changed by: {{ $history->changedByUser ? $history->changedByUser->name : 'System' }}
                        </p>
                        @if($history->notes)
                            <p class="mb-0 small">Notes: {{ $history->notes }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Notes -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Internal Notes</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.enquiries.note', $enquiry) }}" method="POST" class="mb-4">
                @csrf
                <div class="row">
                    <div class="col-md-10">
                        <textarea name="note" class="form-control" rows="2" placeholder="Add internal note..." required></textarea>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Add Note</button>
                    </div>
                </div>
            </form>
            <div class="list-group">
                @foreach($enquiry->notes->sortByDesc('created_at') as $note)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $note->user->name }}</strong>
                            <small class="text-muted">{{ $note->created_at->format('Y-m-d H:i') }}</small>
                        </div>
                        <p class="mb-0 mt-2">{{ $note->note }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection