@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Add New Banner</h5>
                    <a href="{{ route('dashboard.banners.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('dashboard.banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- English Content -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">English Content</h6>
                                
                                <div class="mb-3">
                                    <label for="title_en" class="form-label">Title (English) *</label>
                                    <input type="text" class="form-control @error('title_en') is-invalid @enderror" 
                                           id="title_en" name="title_en" value="{{ old('title_en') }}" required>
                                    @error('title_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="short_description_en" class="form-label">Short Description (English)</label>
                                    <textarea class="form-control @error('short_description_en') is-invalid @enderror" 
                                              id="short_description_en" name="short_description_en" rows="3">{{ old('short_description_en') }}</textarea>
                                    @error('short_description_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="button_text_en" class="form-label">Button Text (English)</label>
                                    <input type="text" class="form-control @error('button_text_en') is-invalid @enderror" 
                                           id="button_text_en" name="button_text_en" value="{{ old('button_text_en') }}">
                                    @error('button_text_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Arabic Content -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">Arabic Content</h6>
                                
                                <div class="mb-3">
                                    <label for="title_ar" class="form-label">Title (Arabic) *</label>
                                    <input type="text" class="form-control @error('title_ar') is-invalid @enderror" 
                                           id="title_ar" name="title_ar" value="{{ old('title_ar') }}" required>
                                    @error('title_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="short_description_ar" class="form-label">Short Description (Arabic)</label>
                                    <textarea class="form-control @error('short_description_ar') is-invalid @enderror" 
                                              id="short_description_ar" name="short_description_ar" rows="3">{{ old('short_description_ar') }}</textarea>
                                    @error('short_description_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="button_text_ar" class="form-label">Button Text (Arabic)</label>
                                    <input type="text" class="form-control @error('button_text_ar') is-invalid @enderror" 
                                           id="button_text_ar" name="button_text_ar" value="{{ old('button_text_ar') }}">
                                    @error('button_text_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Common Fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_link" class="form-label">Button Link</label>
                                    <input type="url" class="form-control @error('button_link') is-invalid @enderror" 
                                           id="button_link" name="button_link" value="{{ old('button_link') }}" 
                                           placeholder="https://example.com">
                                    @error('button_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Banner Image -->
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="banner_image" class="form-label">Banner Image *</label>
                                    <input type="file" class="form-control @error('banner_image') is-invalid @enderror" 
                                           id="banner_image" name="banner_image" accept="image/*" required>
                                    <div class="form-text">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB.</div>
                                    @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('dashboard.banners.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Banner
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    console.log('Banner create page loaded');
    
    // File size validation
    $('#banner_image').on('change', function() {
        const file = this.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        if (file && file.size > maxSize) {
            alert('File size must be less than 2MB');
            this.value = '';
            return false;
        }
        console.log('File selected:', file ? file.name : 'No file');
    });
    
    // Form submission debugging
    $('form').on('submit', function(e) {
        console.log('=== FORM SUBMISSION START ===');
        console.log('Form submitted');
        console.log('Form action:', this.action);
        console.log('Form method:', this.method);
        console.log('CSRF token:', $('input[name="_token"]').val());
        
        // Check if required fields are filled
        const titleEn = $('#title_en').val();
        const titleAr = $('#title_ar').val();
        const bannerImage = $('#banner_image')[0].files[0];
        
        console.log('Title EN:', titleEn);
        console.log('Title AR:', titleAr);
        console.log('Banner Image:', bannerImage);
        
        if (!titleEn || !titleAr || !bannerImage) {
            alert('Please fill in all required fields');
            e.preventDefault();
            return false;
        }
        
        console.log('All required fields are filled, proceeding with submission...');
        
        // Show loading state
        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Creating...');
        
        console.log('=== FORM SUBMISSION END ===');
    });
    
    // Test form element
    console.log('Form element found:', $('form').length);
    console.log('Submit button found:', $('button[type="submit"]').length);
});
</script>
@endpush
