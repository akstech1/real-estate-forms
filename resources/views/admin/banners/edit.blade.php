@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h1 class="h4">{{ __('Edit Banner') }}</h1>
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
                <h6 class="card-title mb-0">{{ __('Edit Banner') }}: {{ $banner->title }}</h6>
            </div>
            <div class="card-body py-2">
                <form action="{{ route('dashboard.home.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-2">
                        <label for="title" class="form-label small">{{ __('Title') }} *</label>
                        <input type="text" 
                               class="form-control form-control-sm @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $banner->title) }}" 
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
                                  rows="2">{{ old('description', $banner->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-2">
                        <label for="image" class="form-label small">{{ __('Image') }}</label>
                        <input type="file" 
                               class="form-control form-control-sm @error('image') is-invalid @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                        <small class="form-text text-muted">Leave empty to keep current image. Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if($banner->image)
                    <div class="mb-2">
                        <label class="form-label small">Current Image</label>
                        <div>
                            <img src="{{ asset('storage/' . $banner->image) }}" 
                                 alt="{{ $banner->title }}" 
                                 class="img-thumbnail" 
                                 style="max-width: 150px;">
                        </div>
                    </div>
                    @endif
                    
                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="link" class="form-label small">{{ __('Link URL') }}</label>
                                <input type="url" 
                                       class="form-control form-control-sm @error('link') is-invalid @enderror" 
                                       id="link" 
                                       name="link" 
                                       value="{{ old('link', $banner->link) }}" 
                                       placeholder="https://example.com">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $banner->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="is_active">
                                        {{ __('Active') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i>{{ __('Update') }}
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
                <h6 class="card-title mb-0">{{ __('Banner Info') }}</h6>
            </div>
            <div class="card-body py-2">
                <p class="small mb-1"><strong>{{ __('Created') }}:</strong> {{ $banner->created_at->format('M d, Y H:i') }}</p>
                <p class="small mb-1"><strong>{{ __('Updated') }}:</strong> {{ $banner->updated_at->format('M d, Y H:i') }}</p>
                <p class="small mb-0"><strong>{{ __('Status') }}:</strong> 
                    <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $banner->is_active ? __('Active') : __('Inactive') }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
