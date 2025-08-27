@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Edit Testimonial</h1>
                <p class="text-muted small mb-0">Update testimonial information</p>
            </div>
            <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Testimonials
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="fas fa-edit me-2 text-primary"></i>Edit Testimonial #{{ $testimonial->id }}
        </h6>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    
                    <div class="mb-3">
                        <label for="name_en" class="form-label">Name (English) *</label>
                        <input type="text" 
                               class="form-control @error('name_en') is-invalid @enderror" 
                               id="name_en" 
                               name="name_en" 
                               value="{{ old('name_en', $testimonial->name_en) }}" 
                               required>
                        @error('name_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="short_description_en" class="form-label">Short Description (English) *</label>
                        <textarea class="form-control @error('short_description_en') is-invalid @enderror" 
                                  id="short_description_en" 
                                  name="short_description_en" 
                                  rows="4" 
                                  required>{{ old('short_description_en', $testimonial->short_description_en) }}</textarea>
                        <div class="form-text">Maximum 1000 characters</div>
                        @error('short_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    
                    <div class="mb-3">
                        <label for="name_ar" class="form-label">Name (Arabic) *</label>
                        <input type="text" 
                               class="form-control @error('name_ar') is-invalid @enderror" 
                               id="name_ar" 
                               name="name_ar" 
                               value="{{ old('name_ar', $testimonial->name_ar) }}" 
                               required>
                        @error('name_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="short_description_ar" class="form-label">Short Description (Arabic) *</label>
                        <textarea class="form-control @error('short_description_ar') is-invalid @enderror" 
                                  id="short_description_ar" 
                                  name="short_description_ar" 
                                  rows="4" 
                                  required>{{ old('short_description_ar', $testimonial->short_description_ar) }}</textarea>
                        <div class="form-text">Maximum 1000 characters</div>
                        @error('short_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating *</label>
                        <select class="form-select @error('rating') is-invalid @enderror" 
                                id="rating" 
                                name="rating" 
                                required>
                            <option value="">Select Rating</option>
                            @for($i = 1; $i <= 5; $i += 0.5)
                                <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>
                                    {{ $i }} {{ $i == 1 ? 'Star' : 'Stars' }}
                                </option>
                            @endfor
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="is_active" class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (visible to users)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <!-- Current Image -->
            @if($testimonial->getFirstMedia('image'))
                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    <div class="border rounded p-3 text-center">
                        <img src="{{ $testimonial->getFirstMediaUrl('image') }}" 
                             alt="{{ $testimonial->name_en }}" 
                             class="img-fluid rounded" 
                             style="max-height: 200px;">
                    </div>
                </div>
            @endif
            
            <!-- Image Upload -->
            <div class="mb-4">
                <label for="image" class="form-label">Update Profile Image</label>
                <input type="file" 
                       class="form-control @error('image') is-invalid @enderror" 
                       id="image" 
                       name="image" 
                       accept="image/jpeg,image/png,image/jpg,image/webp">
                <div class="form-text">
                    Leave empty to keep current image. Accepted formats: JPEG, PNG, JPG, WebP. Maximum size: 2MB.
                </div>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Preview Image -->
            <div class="mb-4" id="image-preview" style="display: none;">
                <label class="form-label">New Image Preview</label>
                <div class="border rounded p-3 text-center">
                    <img id="preview-img" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Testimonial
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endpush
