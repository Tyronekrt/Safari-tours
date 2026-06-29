@extends('layouts.admin')

@section('title', 'Packages Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Packages</h1>
        <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Package
        </a>
    </div>

    <!-- Packages Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Enquiries</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packages as $package)
                            <tr>
                                <td>{{ $package->id }}</td>
                                <td>
                                    <strong>{{ $package->title }}</strong>
                                    <p class="mb-0 small text-muted">{{ Str::limit($package->short_desc, 50) }}</p>
                                </td>
                                <td>
                                    @if($package->category)
                                        {{ $package->category->name }}
                                    @else
                                        <span class="text-muted">No category</span>
                                    @endif
                                </td>
                                <td>
                                    @if($package->price)
                                        ${{ number_format($package->price, 2) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $package->duration ?? 'N/A' }} days</td>
                                <td>
                                    @if($package->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                    @if($package->is_featured)
                                        <span class="badge bg-warning">Featured</span>
                                    @endif
                                </td>
                                <td>{{ $package->views_count }}</td>
                                <td>{{ $package->enquiries_count }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.packages.toggle-featured', $package) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.packages.toggle-published', $package) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info">
                                                <i class="fas fa-globe"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" class="d-inline" data-delete-form data-confirm-message="Are you sure you want to delete this package?">
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
                                <td colspan="10" class="text-center">No packages found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($packages->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $packages->links() }}
        </div>
    @endif
@endsection