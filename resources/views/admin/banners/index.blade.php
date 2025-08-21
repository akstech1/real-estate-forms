@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4">{{ __('Banner Management') }}</h1>
            <a href="{{ route('dashboard.home.banners.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>{{ __('Add Banner') }}
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header py-2">
        <h6 class="card-title mb-0">{{ __('Banners') }}</h6>
    </div>
    <div class="card-body py-2">
        @if($banners->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Link') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <td>
                                <strong>{{ $banner->title }}</strong>
                                @if($banner->description)
                                    <br><small class="text-muted">{{ Str::limit($banner->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($banner->image)
                                    <img src="{{ asset('storage/' . $banner->image) }}" 
                                         alt="{{ $banner->title }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 60px; max-height: 45px;">
                                @else
                                    <span class="text-muted small">No image</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $banner->is_active ? __('Active') : __('Inactive') }}
                                </span>
                            </td>
                            <td>
                                @if($banner->link)
                                    <a href="{{ $banner->link }}" target="_blank" class="text-decoration-none">
                                        <i class="fas fa-external-link-alt fa-sm"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('dashboard.home.banners.edit', $banner) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.home.banners.destroy', $banner) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('{{ __("Are you sure you want to delete this banner?") }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-3">
                <i class="fas fa-images fa-2x text-muted mb-2"></i>
                <p class="text-muted small">{{ __('No banners found') }}</p>
                <a href="{{ route('dashboard.home.banners.create') }}" class="btn btn-primary btn-sm">
                    {{ __('Add Banner') }}
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
