@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Edit Terms & Conditions</h1>
                <p class="text-muted small mb-0">Update terms and conditions</p>
            </div>
            <a href="{{ route('dashboard.terms.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Terms
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="fas fa-edit me-2 text-primary"></i>Edit Terms & Conditions #{{ $term->id }}
        </h6>
    </div>
    <div class="card-body">
        <form action="{{ route('dashboard.terms.update', $term) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    
                    <div class="mb-3">
                        <label for="heading_en" class="form-label">Heading (English) *</label>
                        <textarea class="form-control @error('heading_en') is-invalid @enderror" 
                                  id="heading_en" name="heading_en" rows="3" required 
                                  maxlength="500">{{ old('heading_en', $term->heading_en) }}</textarea>
                        <div class="form-text">
                            <span id="charCountEn">0</span> / 500 characters
                        </div>
                        @error('heading_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description_en" class="form-label">Description (English) *</label>
                        <textarea class="form-control @error('description_en') is-invalid @enderror" 
                                  id="description_en" name="description_en" rows="4" required>{{ old('description_en', $term->description_en) }}</textarea>
                        @error('description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    
                    <div class="mb-3">
                        <label for="heading_ar" class="form-label">Heading (Arabic) *</label>
                        <textarea class="form-control @error('heading_ar') is-invalid @enderror" 
                                  id="heading_ar" name="heading_ar" rows="3" required 
                                  maxlength="500">{{ old('heading_ar', $term->heading_ar) }}</textarea>
                        <div class="form-text">
                            <span id="charCountAr">0</span> / 500 characters
                        </div>
                        @error('heading_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description_ar" class="form-label">Description (Arabic) *</label>
                        <textarea class="form-control @error('description_ar') is-invalid @enderror" 
                                  id="description_ar" name="description_ar" rows="4" required>{{ old('description_ar', $term->description_ar) }}</textarea>
                        @error('description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                   {{ old('is_active', $term->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active (visible to users)
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('dashboard.terms.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Terms
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Terms Preview -->
<div class="card mt-4">
    <div class="card-header">
        <h6 class="card-title mb-0">
            <i class="fas fa-eye me-2 text-info"></i>Live Preview
        </h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-primary mb-3">English Preview</h6>
                <div class="terms-preview">
                    <h6 class="fw-bold" id="previewHeadingEn">{{ $term->heading_en }}</h6>
                    <p class="text-muted" id="previewDescriptionEn">{{ $term->description_en }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="text-primary mb-3">Arabic Preview</h6>
                <div class="terms-preview">
                    <h6 class="fw-bold" id="previewHeadingAr">{{ $term->heading_ar }}</h6>
                    <p class="text-muted" id="previewDescriptionAr">{{ $term->description_ar }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const headingEn = document.getElementById('heading_en');
    const headingAr = document.getElementById('heading_ar');
    const charCountEn = document.getElementById('charCountEn');
    const charCountAr = document.getElementById('charCountAr');
    
    // Character counters
    function updateCharCount(textarea, counter) {
        const length = textarea.value.length;
        counter.textContent = length;
        
        if (length > 450) {
            counter.className = 'text-warning';
        } else if (length > 500) {
            counter.className = 'text-danger';
        } else {
            counter.className = 'text-muted';
        }
    }
    
    // Initialize character counts
    updateCharCount(headingEn, charCountEn);
    updateCharCount(headingAr, charCountAr);
    
    // Update character counts on input
    headingEn.addEventListener('input', () => updateCharCount(headingEn, charCountEn));
    headingAr.addEventListener('input', () => updateCharCount(headingAr, charCountAr));
    
    // Live preview updates
    function updatePreview() {
        document.getElementById('previewHeadingEn').textContent = headingEn.value;
        document.getElementById('previewDescriptionEn').textContent = document.getElementById('description_en').value;
        document.getElementById('previewHeadingAr').textContent = headingAr.value;
        document.getElementById('previewDescriptionAr').textContent = document.getElementById('description_ar').value;
    }
    
    // Update preview on input
    headingEn.addEventListener('input', updatePreview);
    headingAr.addEventListener('input', updatePreview);
    document.getElementById('description_en').addEventListener('input', updatePreview);
    document.getElementById('description_ar').addEventListener('input', updatePreview);
    
    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });
});
</script>
@endpush

<style>
.terms-preview {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
    border-left: 4px solid #007bff;
}

.terms-preview h6 {
    color: #495057;
    margin-bottom: 0.5rem;
}

.terms-preview p {
    margin-bottom: 0;
    line-height: 1.6;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
}

.card-header .card-title {
    color: #495057;
    font-weight: 600;
}
</style>
