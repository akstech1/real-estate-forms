@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Testimonial Details</h1>
                <p class="text-muted small mb-0">View testimonial information</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.testimonials.edit', $testimonial) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit me-2"></i>Edit Testimonial
                </a>
                <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Back to Testimonials
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Main Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Testimonial Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Name (English)</label>
                        <p class="mb-0">{{ $testimonial->name_en }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Name (Arabic)</label>
                        <p class="mb-0">{{ $testimonial->name_ar }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Short Description (English)</label>
                        <p class="mb-0">{{ $testimonial->short_description_en }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Short Description (Arabic)</label>
                        <p class="mb-0">{{ $testimonial->short_description_ar }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Rating</label>
                        <div class="d-flex align-items-center">
                            <span class="text-warning me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </span>
                            <span class="badge bg-primary fs-6">{{ $testimonial->rating }}/5</span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <div>
                            @if($testimonial->is_active)
                                <span class="badge bg-success fs-6">Active</span>
                            @else
                                <span class="badge bg-secondary fs-6">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs me-2 text-primary"></i>Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('dashboard.testimonials.edit', $testimonial) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Testimonial
                    </a>
                    
                    <form action="{{ route('dashboard.testimonials.toggle-status', $testimonial) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-{{ $testimonial->is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                            {{ $testimonial->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    <form action="{{ route('dashboard.testimonials.destroy', $testimonial) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this testimonial? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Delete Testimonial
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Image Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-image me-2 text-primary"></i>Profile Image
                </h6>
            </div>
            <div class="card-body text-center">
                @if($testimonial->getFirstMedia('image'))
                    <img src="{{ $testimonial->getFirstMediaUrl('image') }}" 
                         alt="{{ $testimonial->name_en }}" 
                         class="img-fluid rounded" 
                         style="max-height: 300px;">
                @else
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                         style="width: 200px; height: 200px; margin: 0 auto;">
                        <i class="fas fa-user fa-3x text-white"></i>
                    </div>
                    <p class="text-muted mt-2">No image uploaded</p>
                @endif
            </div>
        </div>

        <!-- Metadata Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-database me-2 text-primary"></i>Metadata
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Created At</label>
                    <p class="mb-0">{{ $testimonial->created_at->format('F d, Y \a\t g:i A') }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Last Updated</label>
                    <p class="mb-0">{{ $testimonial->updated_at->format('F d, Y \a\t g:i A') }}</p>
                </div>
                <div class="mb-0">
                    <label class="form-label fw-bold">ID</label>
                    <p class="mb-0">{{ $testimonial->id }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
