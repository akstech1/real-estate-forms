@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Dashboard Overview</h1>
                <p class="text-muted small mb-0">Welcome to your admin dashboard</p>
            </div>
            <div class="text-end">
                <small class="text-muted">Last updated: {{ now()->format('M d, Y H:i') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 dashboard-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-images fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title mb-1">Banners</h6>
                        <h3 class="mb-0 fw-bold text-primary">{{ $counts['banners'] }}</h3>
                        <small class="text-muted">Total banners</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('dashboard.banners.index') }}" class="btn btn-sm btn-outline-primary w-100">
                    <i class="fas fa-eye me-2"></i>View All
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 dashboard-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-question-circle fa-2x text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title mb-1">FAQs</h6>
                        <h3 class="mb-0 fw-bold text-success">{{ $counts['faqs'] }}</h3>
                        <small class="text-muted">Total questions</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('dashboard.faqs.index') }}" class="btn btn-sm btn-outline-success w-100">
                    <i class="fas fa-eye me-2"></i>View All
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 dashboard-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-cogs fa-2x text-info"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title mb-1">Services</h6>
                        <h3 class="mb-0 fw-bold text-info">{{ $counts['services'] }}</h3>
                        <small class="text-muted">Total services</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('dashboard.services.index') }}" class="btn btn-sm btn-outline-info w-100">
                    <i class="fas fa-eye me-2"></i>View All
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 dashboard-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-comments fa-2x text-warning"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title mb-1">Testimonials</h6>
                        <h3 class="mb-0 fw-bold text-warning">{{ $counts['testimonials'] }}</h3>
                        <small class="text-muted">Total reviews</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-sm btn-outline-warning w-100">
                    <i class="fas fa-eye me-2"></i>View All
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Additional Statistics Row -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 dashboard-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-secondary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-handshake fa-2x text-secondary"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title mb-1">Partners</h6>
                        <h3 class="mb-0 fw-bold text-secondary">{{ $counts['partners'] }}</h3>
                        <small class="text-muted">Total partners</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('dashboard.partners.index') }}" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="fas fa-eye me-2"></i>View All
                </a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 dashboard-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-link fa-2x text-danger"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title mb-1">Links</h6>
                        <h3 class="mb-0 fw-bold text-danger">{{ $counts['links'] }}</h3>
                        <small class="text-muted">Total links</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('dashboard.links.index') }}" class="btn btn-sm btn-outline-danger w-100">
                    <i class="fas fa-eye me-2"></i>View All
                </a>
            </div>
        </div>
    </div>

    {{-- Roles widget hidden - functionality preserved for future use --}}
    {{-- <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 dashboard-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-dark bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-user-shield fa-2x text-dark"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="card-title mb-1">Roles</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ $counts['roles'] }}</h3>
                        <small class="text-muted">Total roles</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('dashboard.roles.index') }}" class="btn btn-sm btn-outline-dark w-100">
                    <i class="fas fa-eye me-2"></i>View All
                </a>
            </div>
        </div>
    </div> --}}



</div>


@endsection

@push('styles')
<style>
.dashboard-card {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.dashboard-card .card-body {
    padding: 1.5rem;
}

.dashboard-card .card-footer {
    padding: 1rem 1.5rem;
}

.dashboard-card .bg-opacity-10 {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}

.dashboard-card .bg-success.bg-opacity-10 {
    background-color: rgba(var(--bs-success-rgb), 0.1) !important;
}

.dashboard-card .bg-info.bg-opacity-10 {
    background-color: rgba(var(--bs-info-rgb), 0.1) !important;
}

.dashboard-card .bg-warning.bg-opacity-10 {
    background-color: rgba(var(--bs-warning-rgb), 0.1) !important;
}

.dashboard-card .bg-secondary.bg-opacity-10 {
    background-color: rgba(var(--bs-secondary-rgb), 0.1) !important;
}

.dashboard-card .bg-danger.bg-opacity-10 {
    background-color: rgba(var(--bs-danger-rgb), 0.1) !important;
}

.dashboard-card .bg-dark.bg-opacity-10 {
    background-color: rgba(var(--bs-dark-rgb), 0.1) !important;
}

.list-group-item {
    border: none;
    padding: 1rem 0;
    transition: background-color 0.2s ease;
}

.list-group-item:hover {
    background-color: rgba(0,0,0,0.02);
}

.list-group-item:not(:last-child) {
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.btn-outline-primary:hover,
.btn-outline-success:hover,
.btn-outline-info:hover,
.btn-outline-warning:hover,
.btn-outline-secondary:hover,
.btn-outline-danger:hover,
.btn-outline-dark:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.rounded-circle {
    transition: transform 0.3s ease;
}

.dashboard-card:hover .rounded-circle {
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .dashboard-card .card-body {
        padding: 1rem;
    }
    
    .dashboard-card .card-footer {
        padding: 0.75rem 1rem;
    }
}
</style>
@endpush
