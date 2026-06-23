@extends('layouts.app')

@section('title', 'Thank You')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card">
                    <div class="card-body py-5">
                        <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                        <h1 class="card-title mb-3">Thank You!</h1>
                        <p class="card-text lead mb-4">Your enquiry has been submitted successfully. Our team will contact you within 24 hours with a customized quote.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('home') }}" class="btn btn-primary">Return Home</a>
                            <a href="{{ route('packages.index') }}" class="btn btn-outline-primary">Browse More Packages</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection