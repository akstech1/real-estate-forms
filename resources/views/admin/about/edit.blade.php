@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Edit About Us</h1>
                <p class="text-muted small mb-0">Update company information and content section by section</p>
            </div>
        </div>
    </div>
</div>

<!-- Header Section -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">
            <i class="fas fa-heading me-2 text-primary"></i>Header Section
        </h6>
        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('headerForm').submit()">
            <i class="fas fa-save me-2"></i>Update Header
        </button>
    </div>
    <div class="card-body">
        <form id="headerForm" action="{{ route('dashboard.home.about.header.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                <div class="form-text">Accepted formats: JPEG, PNG, JPG, WebP. <strong>Max size: 2MB per image</strong></div>
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
        </form>
    </div>
</div>

<!-- Platform Overview Section -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">
            <i class="fas fa-desktop me-2 text-success"></i>Platform Overview
        </h6>
        <button type="button" class="btn btn-success btn-sm" onclick="document.getElementById('platformForm').submit()">
            <i class="fas fa-save me-2"></i>Update Platform
        </button>
    </div>
    <div class="card-body">
        <form id="platformForm" action="{{ route('dashboard.home.about.platform.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                <div class="form-text">Select up to 4 images. Accepted formats: JPEG, PNG, JPG, WebP. <strong>Max size: 2MB per image</strong></div>
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
        </form>
    </div>
</div>

<!-- Our Mission Section -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">
            <i class="fas fa-bullseye me-2 text-warning"></i>Our Mission
        </h6>
        <button type="button" class="btn btn-warning btn-sm" onclick="document.getElementById('missionForm').submit()">
            <i class="fas fa-save me-2"></i>Update Mission
        </button>
    </div>
    <div class="card-body">
        <form id="missionForm" action="{{ route('dashboard.home.about.mission.update') }}" method="POST">
            @csrf
            @method('PUT')

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
        </form>
    </div>
</div>

<!-- Our Goals Section -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">
            <i class="fas fa-target me-2 text-info"></i>Our Goals
        </h6>
        <button type="button" class="btn btn-info btn-sm" onclick="document.getElementById('goalsForm').submit()">
            <i class="fas fa-save me-2"></i>Update Goals
        </button>
    </div>
    <div class="card-body">
        <form id="goalsForm" action="{{ route('dashboard.home.about.goals.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                <div class="form-text">Select up to 3 images. Accepted formats: JPEG, PNG, JPG, WebP. <strong>Max size: 2MB per image</strong></div>
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
        </form>
    </div>
</div>

<!-- Home Section -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">
            <i class="fas fa-home me-2 text-warning"></i>Home Section
        </h6>
        <button type="button" class="btn btn-warning btn-sm" onclick="document.getElementById('homeForm').submit()">
            <i class="fas fa-save me-2"></i>Update Home Section
        </button>
    </div>
    <div class="card-body">
        <form id="homeForm" action="{{ route('dashboard.home.about.home.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    <div class="mb-3">
                        <label for="home_short_description_en" class="form-label">Home Short Description (English) *</label>
                        <textarea class="form-control @error('home_short_description_en') is-invalid @enderror"
                                  id="home_short_description_en" name="home_short_description_en" rows="3" required>{{ old('home_short_description_en', $about->home_short_description_en ?? '') }}</textarea>
                        @error('home_short_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="home_button_text_en" class="form-label">Home Button Text (English) *</label>
                        <input type="text" class="form-control @error('home_button_text_en') is-invalid @enderror"
                               id="home_button_text_en" name="home_button_text_en" value="{{ old('home_button_text_en', $about->home_button_text_en ?? '') }}" required>
                        @error('home_button_text_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="count_heading_en" class="form-label">Count Heading (English) *</label>
                        <input type="text" class="form-control @error('count_heading_en') is-invalid @enderror"
                               id="count_heading_en" name="count_heading_en" value="{{ old('count_heading_en', $about->count_heading_en ?? '') }}" required>
                        @error('count_heading_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="count_description_en" class="form-label">Count Description (English) *</label>
                        <textarea class="form-control @error('count_description_en') is-invalid @enderror"
                                  id="count_description_en" name="count_description_en" rows="3" required>{{ old('count_description_en', $about->count_description_en ?? '') }}</textarea>
                        @error('count_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    <div class="mb-3">
                        <label for="home_short_description_ar" class="form-label">Home Short Description (Arabic) *</label>
                        <textarea class="form-control @error('home_short_description_ar') is-invalid @enderror"
                                  id="home_short_description_ar" name="home_short_description_ar" rows="3" required>{{ old('home_short_description_ar', $about->home_short_description_ar ?? '') }}</textarea>
                        @error('home_short_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="home_button_text_ar" class="form-label">Home Button Text (Arabic) *</label>
                        <input type="text" class="form-control @error('home_button_text_ar') is-invalid @enderror"
                               id="home_button_text_ar" name="home_button_text_ar" value="{{ old('home_button_text_ar', $about->home_button_text_ar ?? '') }}" required>
                        @error('home_button_text_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="count_heading_ar" class="form-label">Count Heading (Arabic) *</label>
                        <input type="text" class="form-control @error('count_heading_ar') is-invalid @enderror"
                               id="count_heading_ar" name="count_heading_ar" value="{{ old('count_heading_ar', $about->count_heading_ar ?? '') }}" required>
                        @error('count_heading_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="count_description_ar" class="form-label">Count Description (Arabic) *</label>
                        <textarea class="form-control @error('count_description_ar') is-invalid @enderror"
                                  id="count_description_ar" name="count_description_ar" rows="3" required>{{ old('count_description_ar', $about->count_description_ar ?? '') }}</textarea>
                        @error('count_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Common Fields -->
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="home_button_link" class="form-label">Home Button Link *</label>
                        <input type="url" class="form-control @error('home_button_link') is-invalid @enderror"
                               id="home_button_link" name="home_button_link" value="{{ old('home_button_link', $about->home_button_link ?? '') }}" 
                               placeholder="https://example.com" required>
                        @error('home_button_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="count" class="form-label">Count Display *</label>
                        <input type="text" class="form-control @error('count') is-invalid @enderror"
                               id="count" name="count" value="{{ old('count', $about->count ?? '') }}" 
                               placeholder="1000+" required>
                        @error('count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="home_logo" class="form-label">Home Logo</label>
                        <input type="file" class="form-control @error('home_logo') is-invalid @enderror"
                               id="home_logo" name="home_logo" accept="image/*">
                        <div class="form-text">Accepted formats: JPEG, PNG, JPG, WebP. <strong>Max size: 2MB</strong></div>
                        @error('home_logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($about->home_logo_url)
                        <div class="mt-2">
                            <label class="form-label">Current Logo:</label>
                            <img src="{{ $about->home_logo_url }}" alt="Current Home Logo" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: contain;">
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const platformImagesInput = document.getElementById('platform_images');
    const goalImagesInput = document.getElementById('goal_images');
    const mainImageInput = document.getElementById('main_image');
    const homeLogoInput = document.getElementById('home_logo');

    // File size validation function
    function validateFileSize(file, maxSizeMB = 2) {
        const maxSizeBytes = maxSizeMB * 1024 * 1024;
        return file.size <= maxSizeBytes;
    }

    // Format file size for display
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Main Image Validation (Header Section)
    if (mainImageInput) {
        mainImageInput.addEventListener('change', function() {
            const files = this.files;

            if (files.length > 0) {
                const file = files[0];

                // Check individual file size (2MB limit)
                if (!validateFileSize(file, 2)) {
                    alert(`⚠️ Header image is too large (${formatFileSize(file.size)}). Each image must be 2MB or smaller.`);
                    this.value = ''; // Reset input
                    return false;
                }
            }
        });
    }

    // Platform Images Validation
    platformImagesInput.addEventListener('change', function() {
        const files = this.files;

        // Check number of files
        if (files.length > 4) {
            alert('⚠️ Platform Overview can only have a maximum of 4 images. Please select 4 or fewer images.');
            this.value = ''; // Reset input
            return false;
        }

        // Check each individual file size (2MB limit per file)
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!validateFileSize(file, 2)) {
                alert(`⚠️ Image "${file.name}" is too large (${formatFileSize(file.size)}). Each image must be 2MB or smaller.`);
                this.value = ''; // Reset input
                return false;
            }
        }

        // Check total file size (8MB total limit for all 4 images)
        let totalSize = 0;
        for (let i = 0; i < files.length; i++) {
            totalSize += files[i].size;
        }

        const maxTotalSizeMB = 8; // 4 images × 2MB each
        if (totalSize > maxTotalSizeMB * 1024 * 1024) {
            alert(`⚠️ Total file size (${formatFileSize(totalSize)}) exceeds ${maxTotalSizeMB}MB limit. Please select smaller images.`);
            this.value = ''; // Reset input
            return false;
        }
    });

    // Goal Images Validation
    goalImagesInput.addEventListener('change', function() {
        const files = this.files;

        // Check number of files
        if (files.length > 3) {
            alert('⚠️ Our Goals can only have a maximum of 3 images. Please select 3 or fewer images.');
            this.value = ''; // Reset input
            return false;
        }

        // Check each individual file size (2MB limit per file)
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (!validateFileSize(file, 2)) {
                alert(`⚠️ Image "${file.name}" is too large (${formatFileSize(file.size)}). Each image must be 2MB or smaller.`);
                this.value = ''; // Reset input
                return false;
            }
        }

        // Check total file size (6MB total limit for all 3 images)
        let totalSize = 0;
        for (let i = 0; i < files.length; i++) {
            totalSize += files[i].size;
        }

        const maxTotalSizeMB = 6; // 3 images × 2MB each
        if (totalSize > maxTotalSizeMB * 1024 * 1024) {
            alert(`⚠️ Total file size (${formatFileSize(totalSize)}) exceeds ${maxTotalSizeMB}MB limit. Please select smaller images.`);
            this.value = ''; // Reset input
            return false;
        }
    });

    // Home Logo Validation
    if (homeLogoInput) {
        homeLogoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file && !validateFileSize(file, 2)) {
                alert(`⚠️ Home logo "${file.name}" is too large (${formatFileSize(file.size)}). The logo must be 2MB or smaller.`);
                this.value = ''; // Reset input
                return false;
            }
        });
    }

    // Add loading states to all update buttons
    const updateButtons = document.querySelectorAll('button[onclick*="submit()"]');
    updateButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.disabled = true;
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';

            // Re-enable button after form submission (fallback)
            setTimeout(() => {
                this.disabled = false;
                this.innerHTML = originalText;
            }, 5000);
        });
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

.form-label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    border: 1px solid #bee5eb;
    color: #0c5460;
}

.alert-info i {
    color: #17a2b8;
}
</style>
