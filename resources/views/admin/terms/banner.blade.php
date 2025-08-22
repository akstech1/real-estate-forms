@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Terms & Conditions Banner Image</h1>
                <p class="text-muted small mb-0">Manage the banner image for the Terms & Conditions section</p>
            </div>
            <a href="{{ route('dashboard.terms.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Terms
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-image me-2 text-info"></i>Banner Image Settings
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.terms.banner.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="banner_image" class="form-label">Terms & Conditions Banner Image *</label>
                        <input type="file" class="form-control @error('banner_image') is-invalid @enderror" 
                               id="banner_image" name="banner_image" accept="image/*" required>
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Required. Recommended size: 1200x400px. Accepted formats: JPEG, PNG, JPG, WebP. Max size: 2MB
                        </div>
                        @error('banner_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard.terms.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-eye me-2 text-success"></i>Current Banner
                </h6>
            </div>
            <div class="card-body">
                @if($termsBanner && $termsBanner->banner_image_url)
                    <div class="text-center">
                        <img src="{{ $termsBanner->banner_image_url }}" 
                             alt="Current Terms Banner" 
                             class="img-fluid rounded mb-3" 
                             style="max-width: 100%; height: auto;">
                        
                        <div class="d-grid gap-2">
                            <a href="{{ $termsBanner->banner_image_url }}" 
                               target="_blank" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-external-link-alt me-2"></i>View Full Size
                            </a>
                        </div>
                         
                         <div class="mt-3">
                             <small class="text-muted">
                                 <i class="fas fa-info-circle me-1"></i>
                                 This image will be displayed at the top of your Terms & Conditions page
                             </small>
                         </div>
                     </div>
                @else
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-image fa-3x text-muted opacity-50"></i>
                        </div>
                        <h6 class="text-muted">No Banner Image</h6>
                        <p class="text-muted small mb-0">
                            Upload an image to set as your Terms & Conditions banner
                        </p>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2 text-warning"></i>Tips
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Use high-quality images for better appearance
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Keep file size under 2MB for faster loading
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Consider using images that represent legal documents
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        Test how it looks on different screen sizes
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('banner_image');
    const currentBanner = document.querySelector('.card-body img');
    
    // Preview new image before upload
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Validate file size
            if (file.size > 2 * 1024 * 1024) { // 2MB
                alert('File size must be less than 2MB');
                this.value = '';
                return;
            }
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, JPG, or WebP)');
                this.value = '';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                if (currentBanner) {
                    currentBanner.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const fileInput = document.getElementById('banner_image');
        
        // Banner image is required
        if (!fileInput.files.length) {
            e.preventDefault();
            alert('Please select a banner image.');
            return;
        }
      
      // Show loading state
      const submitBtn = this.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
  });
});
</script>
@endpush

<style>
.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
}

.card-header .card-title {
    color: #495057;
    font-weight: 600;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.form-check-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.list-unstyled li {
    font-size: 0.875rem;
}

.list-unstyled li i {
    width: 16px;
}
</style>
