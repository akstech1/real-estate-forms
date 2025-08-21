@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">FAQ Details</h1>
                <p class="text-muted small mb-0">View frequently asked question information</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard.faqs.edit', $faq) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit me-2"></i>Edit FAQ
                </a>
                <a href="{{ route('dashboard.faqs.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Back to FAQs
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-question-circle me-2 text-primary"></i>FAQ #{{ $faq->sort_order }}
                    </h6>
                    <div>
                        @if($faq->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">English Content</h6>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Question:</label>
                            <div class="p-3 bg-light rounded">
                                {{ $faq->question_en }}
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Answer:</label>
                            <div class="p-3 bg-light rounded">
                                {!! nl2br(e($faq->answer_en)) !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Arabic Content</h6>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Question:</label>
                            <div class="p-3 bg-light rounded">
                                {{ $faq->question_ar }}
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Answer:</label>
                            <div class="p-3 bg-light rounded">
                                {!! nl2br(e($faq->answer_ar)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Sort Order:</label>
                            <div class="p-2 bg-light rounded">
                                {{ $faq->sort_order }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status:</label>
                            <div class="p-2 bg-light rounded">
                                @if($faq->is_active)
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-muted">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Created:</label>
                            <div class="p-2 bg-light rounded">
                                {{ $faq->created_at->format('M d, Y \a\t g:i A') }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Last Updated:</label>
                            <div class="p-2 bg-light rounded">
                                {{ $faq->updated_at->format('M d, Y \a\t g:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2 text-info"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard.faqs.edit', $faq) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit This FAQ
                    </a>
                    
                    <form action="{{ route('dashboard.faqs.toggle-status', $faq) }}" method="POST" class="d-grid">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-warning">
                            <i class="fas fa-{{ $faq->is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                            {{ $faq->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    
                    <form action="{{ route('dashboard.faqs.destroy', $faq) }}" method="POST" class="d-grid delete-faq-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this FAQ?')">
                            <i class="fas fa-trash me-2"></i>Delete FAQ
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2 text-success"></i>Statistics
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary mb-1">{{ $faq->sort_order }}</h4>
                            <small class="text-muted">Position</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success mb-1">
                            @if($faq->is_active)
                                <i class="fas fa-check-circle"></i>
                            @else
                                <i class="fas fa-times-circle"></i>
                            @endif
                        </h4>
                        <small class="text-muted">Status</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-clock me-2 text-warning"></i>Timeline
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Created</h6>
                            <small class="text-muted">{{ $faq->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    
                    @if($faq->updated_at != $faq->created_at)
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Updated</h6>
                            <small class="text-muted">{{ $faq->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this FAQ? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced delete confirmation
    document.querySelectorAll('.delete-faq-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            const confirmBtn = document.getElementById('confirmDelete');
            
            confirmBtn.onclick = () => {
                form.submit();
                modal.hide();
            };
            
            modal.show();
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

.bg-light {
    background-color: #f8f9fa !important;
    border: 1px solid #e9ecef;
}

.timeline {
    position: relative;
    padding-left: 1rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 1rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -1.5rem;
    top: 0.25rem;
    width: 0.75rem;
    height: 0.75rem;
    border-radius: 50%;
}

.timeline-content h6 {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.timeline-content small {
    font-size: 0.75rem;
}

.border-end {
    border-right: 1px solid #dee2e6 !important;
}

.form-label.fw-bold {
    color: #495057;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>
