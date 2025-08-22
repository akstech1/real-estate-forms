@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Edit Partner</h1>
                <p class="text-muted small mb-0">Update partner information</p>
            </div>
            <a href="{{ route('dashboard.partners.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Partners
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('dashboard.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">English Content</h6>
                    
                    <div class="mb-3">
                        <label for="title_en" class="form-label">Title (English) *</label>
                        <input type="text" class="form-control @error('title_en') is-invalid @enderror" 
                               id="title_en" name="title_en" value="{{ old('title_en', $partner->title_en) }}" required>
                        @error('title_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="short_description_en" class="form-label">Short Description (English) *</label>
                        <textarea class="form-control @error('short_description_en') is-invalid @enderror" 
                                  id="short_description_en" name="short_description_en" rows="4" required>{{ old('short_description_en', $partner->short_description_en) }}</textarea>
                        @error('short_description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h6 class="mb-3 text-primary">Arabic Content</h6>
                    
                    <div class="mb-3">
                        <label for="title_ar" class="form-label">Title (Arabic) *</label>
                        <input type="text" class="form-control @error('title_ar') is-invalid @enderror" 
                               id="title_ar" name="title_ar" value="{{ old('title_ar', $partner->title_ar) }}" required>
                        @error('title_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="short_description_ar" class="form-label">Short Description (Arabic) *</label>
                        <textarea class="form-control @error('short_description_ar') is-invalid @enderror" 
                                  id="short_description_ar" name="short_description_ar" rows="4" required>{{ old('short_description_ar', $partner->short_description_ar) }}</textarea>
                        @error('short_description_ar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="logo" class="form-label">Partner Logo</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                               id="logo" name="logo" accept="image/*">
                        <div class="form-text">Accepted formats: JPEG, PNG, JPG, WebP. Max size: 2MB. Leave empty to keep current logo.</div>
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if($partner->logo_url)
                        <div class="mt-2">
                            <label class="form-label">Current Logo:</label>
                            <div class="d-flex align-items-center">
                                <img src="{{ $partner->logo_url }}" alt="Current Logo" class="img-thumbnail me-2" style="width: 100px; height: 100px; object-fit: cover;">
                                <small class="text-muted">This logo will be replaced if you upload a new one.</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="background_colour" class="form-label">Background Colour *</label>
                        <div class="color-input-wrapper">
                            <div class="color-preview-large" id="colorPreview">
                                <i class="fas fa-palette"></i>
                            </div>
                            <div class="color-inputs">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-eye-dropper"></i>
                                    </span>
                                    <input type="color" class="form-control form-control-color @error('background_colour') is-invalid @enderror" 
                                           id="background_colour" name="background_colour" value="{{ old('background_colour', $partner->background_colour) }}" required>
                                    <input type="text" class="form-control" value="{{ old('background_colour', $partner->background_colour) }}" 
                                           id="background_colour_text" placeholder="#ffffff">
                                </div>
                                <div class="color-presets">
                                    <span class="preset-label">Quick Colors:</span>
                                    <div class="preset-colors">
                                        <button type="button" class="color-preset" data-color="#ffffff" style="background-color: #ffffff;"></button>
                                        <button type="button" class="color-preset" data-color="#f8f9fa" style="background-color: #f8f9fa;"></button>
                                        <button type="button" class="color-preset" data-color="#e9ecef" style="background-color: #e9ecef;"></button>
                                        <button type="button" class="color-preset" data-color="#dee2e6" style="background-color: #dee2e6;"></button>
                                        <button type="button" class="color-preset" data-color="#6c757d" style="background-color: #6c757d;"></button>
                                        <button type="button" class="color-preset" data-color="#495057" style="background-color: #495057;"></button>
                                        <button type="button" class="color-preset" data-color="#212529" style="background-color: #212529;"></button>
                                        <button type="button" class="color-preset" data-color="#007bff" style="background-color: #007bff;"></button>
                                        <button type="button" class="color-preset" data-color="#28a745" style="background-color: #28a745;"></button>
                                        <button type="button" class="color-preset" data-color="#ffc107" style="background-color: #ffc107;"></button>
                                        <button type="button" class="color-preset" data-color="#dc3545" style="background-color: #dc3545;"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('background_colour')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="website_link" class="form-label">Website Link</label>
                        <input type="url" class="form-control @error('website_link') is-invalid @enderror" 
                               id="website_link" name="website_link" 
                               value="{{ old('website_link', $partner->website_link) }}"
                               placeholder="https://example.com">
                        <div class="form-text">Optional: Enter the partner's website URL</div>
                        @error('website_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('dashboard.partners.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Partner
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('background_colour');
    const colorText = document.getElementById('background_colour_text');
    const colorPreview = document.getElementById('colorPreview');
    const presetButtons = document.querySelectorAll('.color-preset');
    
    // Update preview and text when color input changes
    colorInput.addEventListener('input', function() {
        const color = this.value;
        colorText.value = color;
        updateColorPreview(color);
    });
    
    // Update color input and preview when text changes
    colorText.addEventListener('input', function() {
        if (this.value.match(/^#[0-9A-F]{6}$/i)) {
            colorInput.value = this.value;
            updateColorPreview(this.value);
        }
    });
    
    // Handle preset color clicks
    presetButtons.forEach(button => {
        button.addEventListener('click', function() {
            const color = this.dataset.color;
            colorInput.value = color;
            colorText.value = color;
            updateColorPreview(color);
        });
    });
    
    // Update color preview
    function updateColorPreview(color) {
        colorPreview.style.backgroundColor = color;
        // Adjust text color for better contrast
        const brightness = getBrightness(color);
        colorPreview.style.color = brightness > 128 ? '#000000' : '#ffffff';
    }
    
    // Calculate brightness for contrast
    function getBrightness(hex) {
        const r = parseInt(hex.substr(1, 2), 16);
        const g = parseInt(hex.substr(3, 2), 16);
        const b = parseInt(hex.substr(5, 2), 16);
        return (r * 299 + g * 587 + b * 114) / 1000;
    }
    
    // Initialize preview
    updateColorPreview(colorInput.value);
});
</script>
<style>
.color-input-wrapper {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.color-preview-large {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    border: 3px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    background-color: #ffffff;
    color: #000000;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.color-preview-large:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.color-inputs {
    flex: 1;
}

.color-presets {
    margin-top: 0.75rem;
}

.preset-label {
    display: block;
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.preset-colors {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.color-preset {
    width: 32px;
    height: 32px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}

.color-preset:hover {
    transform: scale(1.1);
    border-color: #007bff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.color-preset:active {
    transform: scale(0.95);
}

.form-control-color {
    width: 60px;
    height: 38px;
    padding: 0;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
}

.form-control-color:hover {
    border-color: #007bff;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #e2e8f0;
    color: #6c757d;
}
</style>
@endsection
