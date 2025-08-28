@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Edit Link</h5>
                    <a href="{{ route('dashboard.links.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('dashboard.links.update', $link) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- English Content -->
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">English Content</h6>
                                
                                <div class="mb-3">
                                    <label for="title_en" class="form-label">Title (English) *</label>
                                    <input type="text" class="form-control @error('title_en') is-invalid @enderror" 
                                           id="title_en" name="title_en" value="{{ old('title_en', $link->title_en) }}" required>
                                    @error('title_en')
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
                                           id="title_ar" name="title_ar" value="{{ old('title_ar', $link->title_ar) }}" required>
                                    @error('title_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- URL Field -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="url" class="form-label">URL *</label>
                                    <input type="url" class="form-control @error('url') is-invalid @enderror" 
                                           id="url" name="url" value="{{ old('url', $link->url) }}" 
                                           placeholder="https://example.com" required>
                                    <div class="form-text">Enter the full URL including http:// or https://</div>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                               {{ old('is_active', $link->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Logo Field -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    
                                    @if($link->logo_url)
                                        <div class="mb-3">
                                            <label class="form-label">Current Logo:</label>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $link->logo_url }}" alt="Current Link Logo" 
                                                     class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                                <div>
                                                    <p class="form-text mb-1">Current link logo</p>
                                                    <small class="text-muted">Upload a new logo to replace this one</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                           id="logo" name="logo" accept="image/*">
                                    <div class="form-text">Supported formats: JPEG, PNG, JPG, WebP. Max size: 2MB. Leave empty to keep current logo.</div>
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('dashboard.links.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Link
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
    $('#logo').on('change', function() {
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


