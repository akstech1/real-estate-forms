@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Edit About Us</h1>
                <p class="text-muted small mb-0">Update company information and content</p>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('dashboard.home.about.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <!-- Header Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-heading me-2 text-primary"></i>Header Section
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    <div class="mb-3">
                        <label for="header_description_en" class="form-label">Header Description (English) *</label>
                        <textarea class="form-control @error('header_description_en') is-invalid @enderror" 
                                  id="header_description_en" name="header_description_en" rows="4" required>{{ old('header_description_en', $about->header_description_en ?? '') }}</textarea>
                        @error('header_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    <div class="mb-3">
                        <label for="header_description_ar" class="form-label">Header Description (Arabic) *</label>
                        <textarea class="form-control @error('header_description_ar') is-invalid @enderror" 
                                  id="header_description_ar" name="header_description_ar" rows="4" required>{{ old('header_description_ar', $about->header_description_ar ?? '') }}</textarea>
                        @error('header_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="main_image" class="form-label">Main Header Image</label>
                <input type="file" class="form-control @error('main_image') is-invalid @enderror" 
                       id="main_image" name="main_image" accept="image/*">
                <div class="form-text">Accepted formats: JPEG, PNG, JPG, WebP. Max size: 2MB</div>
                @error('main_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @if($about->main_image_url)
                <div class="mt-2">
                    <label class="form-label">Current Image:</label>
                    <img src="{{ $about->main_image_url }}" alt="Current Header Image" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Platform Overview Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-desktop me-2 text-success"></i>Platform Overview
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    <div class="mb-3">
                        <label for="platform_description_en" class="form-label">Platform Description (English) *</label>
                        <textarea class="form-control @error('platform_description_en') is-invalid @enderror" 
                                  id="platform_description_en" name="platform_description_en" rows="4" required>{{ old('platform_description_en', $about->platform_description_en ?? '') }}</textarea>
                        @error('platform_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    <div class="mb-3">
                        <label for="platform_description_ar" class="form-label">Platform Description (Arabic) *</label>
                        <textarea class="form-control @error('platform_description_ar') is-invalid @enderror" 
                                  id="platform_description_ar" name="platform_description_ar" rows="4" required>{{ old('platform_description_ar', $about->platform_description_ar ?? '') }}</textarea>
                        @error('platform_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="platform_images" class="form-label">Platform Images (4 images)</label>
                <input type="file" class="form-control @error('platform_images.*') is-invalid @enderror" 
                       id="platform_images" name="platform_images[]" accept="image/*" multiple>
                <div class="form-text">Select 4 images. Accepted formats: JPEG, PNG, JPG, WebP. Max size: 2MB each</div>
                @error('platform_images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @if($about->platform_images && count($about->platform_images) > 0)
                <div class="mt-3">
                    <label class="form-label">Current Images:</label>
                    <div class="row">
                        @foreach($about->platform_images as $image)
                        <div class="col-md-3 mb-2">
                            <img src="{{ $image->getUrl() }}" alt="Platform Image" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Our Mission Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-bullseye me-2 text-warning"></i>Our Mission
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    <div class="mb-3">
                        <label for="our_mission_heading_en" class="form-label">Mission Heading (English) *</label>
                        <input type="text" class="form-control @error('our_mission_heading_en') is-invalid @enderror" 
                               id="our_mission_heading_en" name="our_mission_heading_en" value="{{ old('our_mission_heading_en', $about->our_mission_heading_en ?? '') }}" required>
                        @error('our_mission_heading_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="our_mission_description_en" class="form-label">Mission Description (English) *</label>
                        <textarea class="form-control @error('our_mission_description_en') is-invalid @enderror" 
                                  id="our_mission_description_en" name="our_mission_description_en" rows="4" required>{{ old('our_mission_description_en', $about->our_mission_description_en ?? '') }}</textarea>
                        @error('our_mission_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="our_mission_vision_description_en" class="form-label">Vision Description (English) *</label>
                        <textarea class="form-control @error('our_mission_vision_description_en') is-invalid @enderror" 
                                  id="our_mission_vision_description_en" name="our_mission_vision_description_en" rows="4" required>{{ old('our_mission_vision_description_en', $about->our_mission_vision_description_en ?? '') }}</textarea>
                        @error('our_mission_vision_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    <div class="mb-3">
                        <label for="our_mission_heading_ar" class="form-label">Mission Heading (Arabic) *</label>
                        <input type="text" class="form-control @error('our_mission_heading_ar') is-invalid @enderror" 
                               id="our_mission_heading_ar" name="our_mission_heading_ar" value="{{ old('our_mission_heading_ar', $about->our_mission_heading_ar ?? '') }}" required>
                        @error('our_mission_heading_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="our_mission_description_ar" class="form-label">Mission Description (Arabic) *</label>
                        <textarea class="form-control @error('our_mission_description_ar') is-invalid @enderror" 
                                  id="our_mission_description_ar" name="our_mission_description_ar" rows="4" required>{{ old('our_mission_description_ar', $about->our_mission_description_ar ?? '') }}</textarea>
                        @error('our_mission_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="our_mission_vision_description_ar" class="form-label">Vision Description (Arabic) *</label>
                        <textarea class="form-control @error('our_mission_vision_description_ar') is-invalid @enderror" 
                                  id="our_mission_vision_description_ar" name="our_mission_vision_description_ar" rows="4" required>{{ old('our_mission_vision_description_ar', $about->our_mission_vision_description_ar ?? '') }}</textarea>
                        @error('our_mission_vision_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Goals Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-target me-2 text-info"></i>Our Goals
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    <div class="mb-3">
                        <label for="our_goal_description_en" class="form-label">Goals Description (English) *</label>
                        <textarea class="form-control @error('our_goal_description_en') is-invalid @enderror" 
                                  id="our_goal_description_en" name="our_goal_description_en" rows="4" required>{{ old('our_goal_description_en', $about->our_goal_description_en ?? '') }}</textarea>
                        @error('our_goal_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    <div class="mb-3">
                        <label for="our_goal_description_ar" class="form-label">Goals Description (Arabic) *</label>
                        <textarea class="form-control @error('our_goal_description_ar') is-invalid @enderror" 
                                  id="our_goal_description_ar" name="our_goal_description_ar" rows="4" required>{{ old('our_goal_description_ar', $about->our_goal_description_ar ?? '') }}</textarea>
                        @error('our_goal_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="goal_images" class="form-label">Goal Images (3 images)</label>
                <input type="file" class="form-control @error('goal_images.*') is-invalid @enderror" 
                       id="goal_images" name="goal_images[]" accept="image/*" multiple>
                <div class="form-text">Select 3 images. Accepted formats: JPEG, PNG, JPG, WebP. Max size: 2MB each</div>
                @error('goal_images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @if($about->goal_images && count($about->goal_images) > 0)
                <div class="mt-3">
                    <label class="form-label">Current Images:</label>
                    <div class="row">
                        @foreach($about->goal_images as $image)
                        <div class="col-md-4 mb-2">
                            <img src="{{ $image->getUrl() }}" alt="Goal Image" class="img-thumbnail" style="width: 100%; height: 100px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="d-flex justify-content-end gap-2 mb-4">
        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
            <i class="fas fa-save me-2"></i>Update About Us
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const platformImagesInput = document.getElementById('platform_images');
    const goalImagesInput = document.getElementById('goal_images');
    const submitBtn = document.getElementById('submitBtn');
    
    // Platform Images Validation
    platformImagesInput.addEventListener('change', function() {
        const files = this.files;
        if (files.length > 4) {
            alert('⚠️ Platform Overview can only have a maximum of 4 images. Please select 4 or fewer images.');
            this.value = ''; // Reset input
            return false;
        }
        
        // Check total file size (optional additional validation)
        let totalSize = 0;
        for (let i = 0; i < files.length; i++) {
            totalSize += files[i].size;
        }
        
        const maxSizeMB = 8; // 4 images × 2MB each
        if (totalSize > maxSizeMB * 1024 * 1024) {
            alert(`⚠️ Total file size exceeds ${maxSizeMB}MB. Please select smaller images or fewer images.`);
            this.value = ''; // Reset input
            return false;
        }
    });
    
    // Goal Images Validation
    goalImagesInput.addEventListener('change', function() {
        const files = this.files;
        if (files.length > 3) {
            alert('⚠️ Our Goals can only have a maximum of 3 images. Please select 3 or fewer images.');
            this.value = ''; // Reset input
            return false;
        }
        
        // Check total file size (optional additional validation)
        let totalSize = 0;
        for (let i = 0; i < files.length; i++) {
            totalSize += files[i].size;
        }
        
        const maxSizeMB = 6; // 3 images × 2MB each
        if (totalSize > maxSizeMB * 1024 * 1024) {
            alert(`⚠️ Total file size exceeds ${maxSizeMB}MB. Please select smaller images or fewer images.`);
            this.value = ''; // Reset input
            return false;
        }
    });
    
    // Form Submission Validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const platformFiles = platformImagesInput.files;
        const goalFiles = goalImagesInput.files;
        
        if (platformFiles.length > 4) {
            e.preventDefault();
            alert('⚠️ Platform Overview can only have a maximum of 4 images. Please select 4 or fewer images.');
            platformImagesInput.value = '';
            return false;
        }
        
        if (goalFiles.length > 3) {
            e.preventDefault();
            alert('⚠️ Our Goals can only have a maximum of 3 images. Please select 3 or fewer images.');
            goalImagesInput.value = '';
            return false;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
    });
});
</script>

<style>
.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
}

.card-header .card-title {
    color: #495057;
    font-weight: 600;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
}
</style>
@endsection
