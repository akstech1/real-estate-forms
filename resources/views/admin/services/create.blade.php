@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Add New Service</h5>
                    <a href="{{ route('dashboard.services.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.services.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="short_description_en" class="form-label">Short Description (English) *</label>
                                    <textarea class="form-control @error('short_description_en') is-invalid @enderror" 
                                              id="short_description_en" name="short_description_en" rows="4" required>{{ old('short_description_en') }}</textarea>
                                    @error('short_description_en')
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
                                    <label for="short_description_ar" class="form-label">Short Description (Arabic) *</label>
                                    <textarea class="form-control @error('short_description_ar') is-invalid @enderror" 
                                              id="short_description_ar" name="short_description_ar" rows="4" required>{{ old('short_description_ar') }}</textarea>
                                    @error('short_description_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Common Fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="main_image" class="form-label">Main Image *</label>
                                    <input type="file" class="form-control @error('main_image') is-invalid @enderror" 
                                           id="main_image" name="main_image" accept="image/*" required>
                                    <div class="form-text">Supported formats: JPEG, PNG, JPG, WebP. Max size: 2MB.</div>
                                    @error('main_image')
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
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('dashboard.services.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Service
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
    // File size validation
    $('#main_image').on('change', function() {
        const file = this.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        if (file && file.size > maxSize) {
            alert('File size must be less than 2MB');
            this.value = '';
            return false;
        }
    });
});
</script>
@endpush

