@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="h4">{{ __('Add Banner') }}</h1>
            <a href="{{ route('dashboard.home.banners.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>{{ __('Back') }}
            </a>
        </div>
    </div>
</div>

<div class="row g-2">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header py-1">
                <h6 class="card-title mb-0">{{ __('Add Banner') }}</h6>
            </div>
            <div class="card-body py-2">
                <form action="{{ route('dashboard.home.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-2">
                        <label for="title" class="form-label small">{{ __('Title') }} *</label>
                        <input type="text" 
                               class="form-control form-control-sm @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-2">
                        <label for="description" class="form-label small">{{ __('Description') }}</label>
                        <textarea class="form-control form-control-sm @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="2">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-2">
                        <label for="image" class="form-label small">{{ __('Image') }} *</label>
                        <input type="file" 
                               class="form-control form-control-sm @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*" 
                               required>
                        <small class="form-text text-muted">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="link" class="form-label small">{{ __('Link URL') }}</label>
                                <input type="url" 
                                       class="form-control form-control-sm @error('link') is-invalid @enderror" 
                                       id="link" 
                                       name="link" 
                                       value="{{ old('link') }}" 
                                       placeholder="https://example.com">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                    <label class="form-check-label small" for="is_active">
                                        {{ __('Active') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i>{{ __('Save') }}
                        </button>
                        <a href="{{ route('dashboard.home.banners.index') }}" class="btn btn-outline-secondary btn-sm">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header py-1">
                <h6 class="card-title mb-0">{{ __('Help') }}</h6>
            </div>
            <div class="card-body py-2">
                <p class="text-muted small mb-2">
                    Create a new banner for your website homepage.
                </p>
                <ul class="text-muted small">
                    <li>Title is required and should be descriptive</li>
                    <li>Image should be high quality and properly sized</li>
                    <li>Link is optional but recommended</li>
                    <li>Active status controls visibility</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
