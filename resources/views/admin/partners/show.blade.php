@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Partner Details</h1>
                <p class="text-muted small mb-0">View partner information</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.partners.edit', $partner) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Partner
                </a>
                <a href="{{ route('dashboard.partners.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Partners
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-image me-2 text-primary"></i>Partner Logo
                </h6>
            </div>
            <div class="card-body text-center">
                @if($partner->logo_url)
                    <img src="{{ $partner->logo_url }}" alt="Partner Logo" class="img-fluid rounded" style="max-height: 200px;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-image fa-3x text-muted"></i>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-palette me-2 text-primary"></i>Background Colour
                </h6>
            </div>
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="color-preview me-3" style="width: 40px; height: 40px; background-color: {{ $partner->background_colour }}; border-radius: 8px; border: 2px solid #ddd;"></div>
                    <span class="font-monospace">{{ $partner->background_colour }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Partner Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">English Content</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title:</label>
                            <p class="mb-0">{{ $partner->title_en }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description:</label>
                            <p class="mb-0">{{ $partner->short_description_en }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Arabic Content</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title:</label>
                            <p class="mb-0">{{ $partner->title_ar }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description:</label>
                            <p class="mb-0">{{ $partner->short_description_ar }}</p>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created:</label>
                            <p class="mb-0">{{ $partner->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Last Updated:</label>
                            <p class="mb-0">{{ $partner->updated_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
