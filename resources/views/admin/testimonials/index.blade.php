@extends('layouts.admin')

@section('title', 'Testimonials Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Testimonials</h1>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Testimonial
        </a>
    </div>

    <!-- Testimonials Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Content</th>
                            <th>Rating</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $testimonial)
                            <tr>
                                <td>{{ $testimonial->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($testimonial->customer_image)
                                            <img src="{{ asset('storage/' . $testimonial->customer_image) }}" class="rounded-circle me-2" alt="{{ $testimonial->customer_name }}" style="width: 40px; height: 40px; object-fit: cover;">
                                        @endif
                                        <strong>{{ $testimonial->customer_name }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 small">{{ Str::limit($testimonial->content, 80) }}</p>
                                </td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                </td>
                                <td>
                                    @if($testimonial->package_name)
                                        {{ $testimonial->package_name }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($testimonial->is_approved)
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-secondary">Pending</span>
                                    @endif
                                    @if($testimonial->is_featured)
                                        <span class="badge bg-warning">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.testimonials.toggle-approved', $testimonial) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.testimonials.toggle-featured', $testimonial) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" data-delete-form data-confirm-message="Are you sure you want to delete this testimonial?">
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
                                <td colspan="7" class="text-center">No testimonials found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($testimonials->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $testimonials->links() }}
        </div>
    @endif
@endsection