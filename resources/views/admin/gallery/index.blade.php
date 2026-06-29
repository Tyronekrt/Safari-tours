@extends('layouts.admin')

@section('title', 'Gallery Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gallery</h1>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Photo
        </a>
    </div>

    <!-- Gallery Grid -->
    <div class="row">
        @forelse($galleries as $gallery)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100">
                    <img src="{{ str_starts_with($gallery->image, 'http') ? $gallery->image : asset('storage/' . $gallery->image) }}" class="card-img-top" alt="{{ $gallery->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $gallery->title }}</h5>
                        @if($gallery->location)
                            <p class="card-text small text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $gallery->location }}</p>
                        @endif
                        @if($gallery->description)
                            <p class="card-text small">{{ Str::limit($gallery->description, 80) }}</p>
                        @endif
                        <div class="mb-2">
                            @if($gallery->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group w-100">
                            <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.gallery.toggle-active', $gallery) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" class="d-inline" data-delete-form data-confirm-message="Are you sure you want to delete this photo?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    No gallery photos found. <a href="{{ route('admin.gallery.create') }}" class="alert-link">Add your first photo</a>.
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $galleries->links() }}
        </div>
    @endif
@endsection